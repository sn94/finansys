 <?= $this->extend("layouts/index") ?>
 <?= $this->section("title") ?>
 ACTUALIZACIÓN DE OPERACIÓN
 <?= $this->endSection() ?>




 <?= $this->section("contenido") ?>






 <input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/pendientes") ?>">


 <div id="loaderplace">

 </div>
 <?php
    echo form_open("operacion/edit",  ["onsubmit" => "guardar(event)"]);
    ?>

 <?php
    $IDNRO =  isset($OPERACION) ?  $OPERACION->IDNRO :  "";
    ?>
 <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
 <?= view("operacion/form") ?>
 </form>


 <script>
     
     //loader spinner

     function show_loader() {
         let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
         $("#loaderplace").html(loader);
     }

     function hide_loader() {
         $("#loaderplace").html("");
     }


     /**Form */




     function campos_requeridos() {
         if ($("#CREDITO").val() == "" || $("#CREDITO").val() == "0") {
             alert("FALTA EL MONTO DE CRÉDITO APROBADO");
             return false;
         }
         if ($("#INTERES").val() == "" || $("#INTERES").val() == "0") {
             alert("DETALLE EL PORCENTAJE DE INTERÉS");
             return false;
         }
         if ($("#CUOTAS").val() == "" || $("#CUOTAS").val() == "0") {
             alert("INGRESE NRO DE CUOTAS");
             return false;
         }
         return true;
     }





     window.onload = function() {

           //formato entero
    let enteros = document.querySelectorAll(".entero");
    Array.prototype.forEach.call(enteros, function(inpu) {
      inpu.oninput = formatoNumerico.formatearEntero;
      $(inpu).addClass("text-right");
    });


    let decimales = document.querySelectorAll(".decimal");
    Array.prototype.forEach.call(decimales, function(inpu) {
      inpu.oninput = formatoNumerico.formatearDecimal;
      $(inpu).addClass("text-right");
    });

    


        //Auto calculo
        let autocalc = document.querySelectorAll("#CREDITO, #INTERES, #CUOTAS,#SEGURO,#GASTOS_ADM ");
        Array.prototype.forEach.call(autocalc, function(inpu) {
           
            let keep = inpu.oninput; 
            inpu.oninput = function(ev) {
             
               
                calcular_montos();
                if( typeof  keep == "function")
               { keep(ev); }
            };
            $(inpu).addClass("text-right");
        });
     }
 </script>

 <?= $this->endSection() ?>