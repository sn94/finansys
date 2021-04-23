<style>
#FICHA-LABORAL thead tr th,  #FICHA-LABORAL tbody tr td{
    padding: 0px !important;
}
</style> 
 <fieldset>
     <legend>DATOS LABORALES</legend>
     <div class="row" id="FICHA-LABORAL-FORM">


       <input name="IDNRO" type="hidden" >
     
         <div class="col-12 col-md-2">
             <label>DESCRIPCIÓN:</label>
             <input maxlength="30" name="DESCRIPCION" type="text" class="form-control">
         </div>
         <div class="col-12 col-md-2">
             <label>TELÉF:</label>
             <input maxlength="20" name="TELEFONO" type="text" class="form-control">
         </div>



         <div class="col-12 col-md-3">
             <label>DOMICILIO:</label>
             <input maxlength="50" name="DOMICILIO" type="text" class="form-control">
         </div>

         <div class="col-12 col-md-2">
             <label>CARGO:</label>
             <input maxlength="20" name="CARGO" type="text" class="form-control">
         </div>
         <div class="col-12 col-md-2">
             <label>SUELDO:</label>
             <input maxlength="10" name="SUELDO" type="text" class="form-control entero">
         </div>


         <div class="col-12 col-md-2">
             <label>HORARIO LABORAL:</label>
             <input maxlength="30" name="HORARIO_LABO" type="text" class="form-control">
         </div>
         <div class="col-12 col-md">
             <label>DEPARTAMENTO:</label>
             <input maxlength="20" name="DEPARTAMENTO" type="text" class="form-control">
         </div>

         <div class="col-12 col-md">
             <label>TIPO EMPRESA:</label>
             <input maxlength="30" name="TIPO_EMPRESA" type="text" class="form-control">
         </div>
         <div class="col-12 col-md">
             <label>ANTIG. AÑOS:</label>
             <input maxlength="2" name="ANTIGUEDAD_ANIOS" type="text" class="form-control entero">
         </div>
         <div class="col-12 col-md">
             <label>ANTIG. MESES:</label>
             <input maxlength="2" name="ANTIGUEDAD_MESES" type="text" class="form-control entero">
         </div>

         <div class="col-12 col-md" style="display: flex;align-items: flex-end;">
             <button onclick="ficha_laboral.cargar()" class="btn btn-sm btn-primary" type="button">CARGAR</button>
         </div>
     </div>


     <div class="container">
         <table id="FICHA-LABORAL" class="table-responsive table table-striped table-hover  table-bordered ">
             <thead>
                 <tr>
                     <th></th>
                     <th></th>
                     <th>ID</th>
                     <th>Descr.</th>
                     <th>Teléf.</th>
                     <th>Domicilio</th>
                     <th>Cargo</th>
                     <th>Sueldo</th>
                     <th>Horario</th>
                     <th>Dep.</th>
                     <th>Tipo</th>
                     <th>Años</th>
                     <th>Meses</th>
                 </tr>
             </thead>
             <tbody>


                 <?php

                    if (isset($ficha_laboral)) :

                        if (sizeof($ficha_laboral) == 0) :
                            echo "Sin registros";
                        else :
                            foreach ($ficha_laboral as $ficha) :  ?>
                             <tr id="ficha-laboral-<?= $ficha->IDNRO ?>">
                                 <td><a onclick="ficha_laboral.edit('ficha-laboral-<?= $ficha->IDNRO ?>')" href='#'> <i class='fa fa-edit'></i> </a>
                                 </td>
                                 <td> <a onclick="ficha_laboral.del('ficha-laboral-<?= $ficha->IDNRO ?>')" href='#'> <i class='fa fa-trash'></i> </a></td>
                                 <td> <?= $ficha->IDNRO ?> </td>
                                 <td> <?= $ficha->DESCRIPCION ?> </td>
                                 <td> <?= $ficha->TELEFONO ?> </td>
                                 <td> <?= $ficha->DOMICILIO ?> </td>
                                 <td> <?= $ficha->CARGO ?> </td>
                                 <td> <?= $ficha->SUELDO ?> </td>
                                 <td> <?= $ficha->HORARIO_LABO ?> </td>
                                 <td> <?= $ficha->DEPARTAMENTO ?> </td>
                                 <td> <?= $ficha->TIPO_EMPRESA ?> </td>
                                 <td> <?= $ficha->ANTIGUEDAD_ANIOS ?> </td>
                                 <td> <?= $ficha->ANTIGUEDAD_MESES ?> </td>
                             </tr>
                 <?php endforeach;
                        endif;
                    endif;  ?>

             </tbody>
         </table>
     </div>
 </fieldset>


 <script>
     var ficha_laboral = {
         selector: "#FICHA-LABORAL-FORM",
         selectorTabla: "#FICHA-LABORAL",

         modelo: [],

         calcNuevoIdRow: function() {
             let nume = document.querySelector(this.selectorTabla + " tbody").children.length + 1;
             return "ficha-laboral-" + nume;
         },
         edit: function(id) {
             this.restaurarModelo();
             //actualizar modelo
             let model = this.modelo.filter((ar) => ar.IDNRO == id)[0];
             //mostrar en el formu para editar
             let selectorTodo = this.selector + " input, " + this.selector + " select";
             Array.prototype.forEach.call(document.querySelectorAll(selectorTodo),
                 function(ar) {
                     ar.value = model[ar.name];
                 });

             window.scrollTo(screen.width, screen.height);
         },
         del: function(id) {

            this.restaurarModelo();
            
             $("#" + id).remove();

             //actualizar modelo
             this.modelo = this.modelo.filter((ar) => ar.IDNRO != id);
             window.scrollTo(screen.width, screen.height);
         },

         limpiarForm: function() {
             let selectorTodo = this.selector + " input, " + this.selector + " select";
             Array.prototype.forEach.call(document.querySelectorAll(selectorTodo),
                 function(ar) {
                     if (ar.tagName.toLowerCase() != "select")
                         ar.value = "";
                 });
         },

         obtenerDataForm: function() {
             let selectorTodo = this.selector + " input, " + this.selector + " select";
             return Array.prototype.reduce.call(document.querySelectorAll(selectorTodo),
                 function(acumu, actual) {

                     let id = actual.name;
                     let val = actual.value;
                     acumu[id] = val;
                     return acumu;
                 }, {});
         },
         restaurarModelo: function() {

            if( this.modelo.length > 0)  return ;
             filas = document.querySelectorAll(this.selectorTabla + " tbody tr");
           this.modelo=  Array.prototype.map.call(filas, function(arg) {

                 let columnas =   Array.prototype.map.call( arg.children , function(ar){
                     return ar.textContent.trim();
                 } );
                 let id = "ficha-laboral-"+ columnas[2];
                 let descripcion = columnas[3];
                 let telefono = columnas[4];
                 let domicilio = columnas[5];
                 let cargo = columnas[6];
                 let sueldo = columnas[7];
                 let horario = columnas[8];
                 let departamento = columnas[9];
                 let tipo_empresa = columnas[10];
                 let anti_anios = columnas[11];
                 let anti_meses = columnas[12];
                 return {
                     IDNRO: id,
                     DESCRIPCION: descripcion,
                     TELEFONO: telefono,
                     DOMICILIO: domicilio,
                     CARGO: cargo,
                     SUELDO: sueldo,
                     HORARIO_LABO: horario,
                     DEPARTAMENTO: departamento,
                     TIPO_EMPRESA: tipo_empresa,
                     ANTIGUEDAD_ANIOS: anti_anios,
                     ANTIGUEDAD_MESES: anti_meses
                 };
             });

         },
         actualizarModelo: function(obj) {

             //EXISTE
             if (this.modelo.filter((ar) => ar.IDNRO == obj.IDNRO).length > 0) {

                 this.modelo = this.modelo.filter((ar) => ar.IDNRO != obj.IDNRO);
                 console.log("actualizar", this.modelo);
                 this.modelo.push(obj);

                 return obj.IDNRO;
             } else {
                 let nuevoId = this.calcNuevoIdRow();
                 this.modelo.push(Object.assign(obj, {
                     IDNRO: nuevoId
                 }));
                 return nuevoId;
             }
         },

         cargar: function() {

            this.restaurarModelo();

             let selectorTodo = this.selector + " input, " + this.selector + " select";

             let datos = this.obtenerDataForm();

             //Cargar a la tabla
             let nuevoId = this.actualizarModelo(datos);
             //acciones
             let eEdit = `ficha_laboral.edit('${nuevoId}')`;
             let eDel = `ficha_laboral.del( '${nuevoId}' )`;
             let bEdit = `<a onclick="${eEdit}" href='#'> <i class='fa fa-edit'></i> </a>`;
             let bDel = `<a   onclick="${eDel}" href='#' > <i class='fa fa-trash'></i> </a>`;

             let camposVisibles = Object.entries(datos).filter(([k, v]) => k != "IDNRO").reduce(
                 (acum, [k, v]) => {
                     acum[k] = v;
                     return acum;
                 }, {}
             );

             let htm = `
        <tr id='${nuevoId}' > <td>${bEdit}</td>  <td>${bDel}</td><td>-</td>  
        ${Object.values(camposVisibles  ).map((ar) => `<td>${ar}</td>`)}
         </tr>
        `;

             //quitar fila si ya existe
             $("#" + nuevoId).remove();

             $(this.selectorTabla + " tbody").append(htm);
             //Limpiar campos
             this.limpiarForm();
         }
     };



     async function guardar_ficha_laboral(ev) {

         ev.preventDefault();
         //     $("#SUBMIT-PERSONALES").prop("disabled", true);

         let idCliente = $("#FORM-LABORAL input[name=NRO_CLIENTE]").val();

         if (idCliente == "" || idCliente == undefined) {
             alert("Guarda primero los datos personales del cliente");
             return;
         }
         let payload = {
             NRO_CLIENTE: idCliente,
             EMPLEOS: ficha_laboral.modelo
         }
         let req = await fetch(ev.target.action, {
             "method": "POST",
             headers: {
                 "Content-Type": "application/json"
             },
             body: JSON.stringify(payload)
         });
         let resp = await req.json();

         if ("auth_error" in resp) {
             alert(resp.auth_error);
             window.location = resp.redirect;
         }


         //$("#SUBMIT-PERSONALES").prop("disabled", false);
         if ("ok" in resp) {

             alert("Guardado");
             refrescar_ficha_laboral(idCliente);
         } else {
             alert(resp.error);
         }
     }


     async function refrescar_ficha_laboral(idcliente) {
         let req = await fetch("<?= base_url("deudor/view-ficha-laboral") ?>/" + idcliente);
         let resp = await req.text();
         $("#FORM-LABORAL-CONTENT").html(resp);
     }
 </script>