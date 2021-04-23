<style>
#FICHA-FAMILIAR thead tr th,  #FICHA-FAMILIAR tbody tr td{
    padding: 0px !important;
}
</style>
 <fieldset>
     <legend>FAMILIA</legend>
     <div class="row" id="FICHA-FAMILIAR-FORM">

         <input maxlength="30" name="IDNRO" type="hidden">

         <div class="col-12 col-md-2">
             <label>CÉDULA:</label>
             <input maxlength="20" name="CEDULA" type="text" class="form-control">
         </div>
         <div class="col-12 col-md-3">
             <label>NOMBRES:</label>
             <input maxlength="50" name="NOMBRE" type="text" class="form-control">
         </div>



         <div class="col-12 col-md-2">
             <label>TELEFÓNO:</label>
             <input maxlength="20" name="TELEFONO" type="text" class="form-control">
         </div>

         <div class="col-12 col-md-5">
             <label>DOMICILIO:</label>
             <input maxlength="50" name="DOMICILIO" type="text" class="form-control">
         </div>
         <div class="col-12 col-md-3">
             <label>EMPLEO:</label>
             <input maxlength="20" name="EMPLEO" type="text" class="form-control">
         </div>

         <div class="col-12 col-md">
             <label>RELACIÓN:</label>
             <select name="RELACION" class="form-control">
                 <option value="CONYUGE">CONYUGE</option>
                 <option value="FAMILIAR">MADRE/PADRE, HERMANO/A, PRIMO/A, Y OTROS</option>
             </select>
         </div>
         <div class="col-12 col-md">
             <label>EMPRESA:</label>
             <input maxlength="30" name="EMPRESA" type="text" class="form-control">
         </div>
         <div class="col-12 col-md">
             <label>DOMICILIO LABORAL:</label>
             <input maxlength="30" name="DOMICI_LABO" type="text" class="form-control">
         </div>
         <div class="col-12 col-md" style="display: flex;align-items: flex-end;">
             <button onclick="ficha_familiar.cargar()" class="btn btn-sm btn-primary" type="button">CARGAR</button>
         </div>
     </div>


     <div class="container">
         <table id="FICHA-FAMILIAR" class="table  table-responsive table-striped table-hover  table-bordered  ">
             <thead>
                 <tr>
                     <th></th>
                     <th></th>
                     <th>ID</th>
                     <th>Cédula</th>
                     <th>Nombre</th>
                     <th>Teléf.</th>
                     <th>Domicilio</th>
                     <th>Empleo</th>
                     <th>Relación</th>
                     <th>Empresa</th>
                     <th>Domici.laboral</th>
                 </tr>
             </thead>
             <tbody>


                 <?php

                    if (isset($ficha_familiar)) :

                        if (sizeof($ficha_familiar) == 0) :
                            echo "Sin registros";
                        else :
                            foreach ($ficha_familiar as $ficha) :  ?>
                             <tr id="ficha-familiar-<?= $ficha->IDNRO ?>">
                                 <td><a onclick="ficha_familiar.edit('ficha-familiar-<?= $ficha->IDNRO ?>')" href='#'> <i class='fa fa-edit'></i> </a>
                                 </td>
                                 <td> <a onclick="ficha_familiar.del('ficha-familiar-<?= $ficha->IDNRO ?>')" href='#'> <i class='fa fa-trash'></i> </a></td>
                                 <td> <?= $ficha->IDNRO ?> </td>
                                 <td> <?= $ficha->CEDULA ?> </td>
                                 <td> <?= $ficha->NOMBRE ?> </td>
                                 <td> <?= $ficha->TELEFONO ?> </td>
                                 <td> <?= $ficha->DOMICILIO ?> </td>
                                 <td> <?= $ficha->EMPLEO ?> </td>
                                 <td> <?= $ficha->RELACION ?> </td>
                                 <td> <?= $ficha->EMPRESA ?> </td>
                                 <td> <?= $ficha->DOMICI_LABO ?> </td>
                             </tr>
                 <?php endforeach;
                        endif;
                    endif;  ?>

             </tbody>
         </table>
     </div>
 </fieldset>


 <script>
     var ficha_familiar = {
         selector: "#FICHA-FAMILIAR-FORM",
         selectorTabla: "#FICHA-FAMILIAR",

         modelo: [],

         calcNuevoIdRow: function() {
             let nume = document.querySelector(this.selectorTabla + " tbody").children.length + 1;
             return "ficha-familiar-" + nume;
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

             if (this.modelo.length > 0) return;
             filas = document.querySelectorAll(this.selectorTabla + " tbody tr");
             this.modelo = Array.prototype.map.call(filas, function(arg) {

                 let columnas = Array.prototype.map.call(arg.children, function(ar) {
                     return ar.textContent.trim();
                 });
                 let id = "ficha-familiar-" + columnas[2];
                 let cedula = columnas[3];
                 let nombre = columnas[4];
                 let telefono = columnas[5];
                 let domicilio = columnas[6];
                 let empleo = columnas[7];
                 let relacion = columnas[8];
                 let empresa = columnas[9];
                 let domici_labo = columnas[10]; 
                 return {
                     IDNRO: id,
                     CEDULA: cedula,
                     NOMBRE: nombre,
                     TELEFONO: telefono,
                     DOMICILIO: domicilio,
                     EMPLEO: empleo,
                     RELACION: relacion,
                     EMPRESA: empresa,
                     DOMICI_LABO: domici_labo
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
             let eEdit = `ficha_familiar.edit('${nuevoId}')`;
             let eDel = `ficha_familiar.del( '${nuevoId}' )`;
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



     async function guardar_ficha_familiar(ev) {

         ev.preventDefault();
         //     $("#SUBMIT-PERSONALES").prop("disabled", true);

         let idCliente = $("#FORM-FAMILIAS input[name=NRO_CLIENTE]").val();
         if (idCliente == "" || idCliente == undefined) {
             alert("Guarda primero los datos personales del cliente");
             return;
         }
         let payload = {
             NRO_CLIENTE: idCliente,
             FAMILIARES: ficha_familiar.modelo
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
             await refrescar_ficha_familiar(idCliente);
         } else {
             alert(resp.error);
         }

     }


     async function refrescar_ficha_familiar(idcliente) {
         let req = await fetch("<?= base_url("deudor/view-ficha-familiar") ?>/" + idcliente);
         let resp = await req.text();
         $("#FORM-FAMILIAS-CONTENT").html(resp);
     }
 </script>