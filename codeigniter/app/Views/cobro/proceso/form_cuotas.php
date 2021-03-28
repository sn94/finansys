 <style>
   #cuotas thead tr th,
   #cuotas tbody tr td {
     font-size: 14px;
     padding: 0px !important;
   }
 </style>


 <input type="hidden" id="CUOTAS-SOURCE" value="<?= base_url("operacion/cuotas/$prestamo_dato->IDNRO") ?>">
 <table id="cuotas" class="table table-hover">
   <thead>
     <tr>
       <th>#</th>
       <th>MONTO</th>
       <th>VENCIMIENTO</th>
       <th>ATRASO</th>
       <th>ESTADO</th>
       <th>FECHA PAGO</th>
     </tr>
   </thead>
   <tbody>

   </tbody>
 </table>




 <script>
   function marcacion(ev) {
     let IDCUOTA = ev.currentTarget.value;
     let POSICION_ACTUAL = -1;

     if (ev.currentTarget.checked) //MARCADO
     {

       //MARCAR LOS CHECKBOX SUPERIORES
       let checks = document.querySelectorAll("#cuotas input[type=checkbox]");
       Array.prototype.forEach.call(checks, function(elemento, indice) {
         if (elemento.value == IDCUOTA) {
           POSICION_ACTUAL = indice;
         }
         if (POSICION_ACTUAL == -1) {
           elemento.checked = true;
         }
       });

     } else { //CUANDO DESMARCA 

       POSICION_ACTUAL = -1;
       //DESMARCAR LOS CHECKBOX INFERIORES
       let checks = document.querySelectorAll("#cuotas input[type=checkbox]");
       Array.prototype.forEach.call(checks, function(elemento, indice) {
         if (elemento.value == IDCUOTA) {
           POSICION_ACTUAL = indice;
         }
         if (POSICION_ACTUAL != -1) {
           elemento.checked = false;
         }
       });
     }
     totalizar(ev);
   }


   function totalizar(ev) {

     let total = 0;

     let checks = document.querySelectorAll("#cuotas input[type=checkbox]");
     let checks_marcados = Array.prototype.filter.call(checks, function(ele) {
       return ele.checked;
     });

     Array.prototype.forEach.call(checks_marcados, function(elemento, indice) {

       //sumar el Saldo de cada cuota
       let fila = elemento.parentNode.parentNode;
       let colSaldo = fila.children[3].firstChild;
       let Saldo = formValidator.limpiarNumero(colSaldo.textContent);


       //total+=  parseInt( quitarSeparador( $("#cate-cuotas").val())  );// REFERENCIA EL TOTAL DE LA CUOTA
       total += parseInt(Saldo); //REFERENCIA EL SALDO DE LA CUOTA
     });

     $("#TOTALCOBRO").val(formatoNumerico.darFormatoEnMillares(total));
   }









   /***Modelo */


   var cuotas_data_model = [];




   function mostrar_cuotas() {


     let td_cons = function(val) {
       return "<td>" + val + "</td>";
     }
     let tr_cons = function(onj) {
       let filas = Object.values(onj).map(td_cons);
       return "<tr>" + filas + "</tr>";
     }

     let html_model = cuotas_data_model.map(function(arg) {

       // let marcador= '<input style=" margin: 0px;" onchange="marcacion(event)" name="ESTADO[]" type="checkbox" value="'+arg.IDNRO+'">';
       return {
         NUMERO: arg.NUMERO,
         MONTO: arg.MONTO,
         VENCIMIENTO: arg.VENCIMIENTO,
         ATRASO: arg.ATRASO,
         ESTADO: arg.ESTADO == "P" ? "PENDIENTE" : "PAGADA",
         FECHA_PAGO: arg.FECHA_PAGO
         //MARCADOR: marcador
       }
     });
     let string_html = html_model.map(tr_cons);
     $("#cuotas tbody").html(string_html);
   }




   async function cargar_modelo_cuotas() {
     let url_cuotas=  $("#CUOTAS-SOURCE").val();
     let req = await fetch(  url_cuotas,  {
       headers: {  formato:  "json"}
     });
     cuotas_data_model = await req.json();


   }
 </script>