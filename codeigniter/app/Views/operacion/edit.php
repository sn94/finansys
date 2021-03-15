 <?= $this->extend("layouts/index") ?>
 <?= $this->section("title") ?>
 ACTUALIZACIÓN DE OPERACIÓN
 <?= $this->endSection() ?>




 <?= $this->section("contenido") ?>






 <?php
    //Url solicitante
    $request = \Config\Services::request();
    $referer = is_null($request->getHeader("Referer")) ?  ""  :  $request->getHeader("Referer")->getValue();
    ?>
 <input type="hidden" id="OPERACIONES-INDEX" value="<?= $referer ?>">

 <div id="loaderplace">

 </div>
 <?php
    echo form_open("operacion/edit",  ["onsubmit" => "guardar(event)"]);
    ?>

 <?php
    $IDNRO =  isset($OPERACION) ?  $OPERACION->IDNRO :  "";
    ?>
 <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
 <?= view("operacion/forms/index") ?>
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






     window.onload = function() {


         obtener_parametros();


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
         let autocalc = document.querySelectorAll("#CREDITO, #INTERES, #NRO_CUOTAS,#SEGURO,#GASTOS_ADM ");
         Array.prototype.forEach.call(autocalc, function(inpu) {

             let keep = inpu.oninput;
             inpu.oninput = function(ev) {


                 calcular_montos();
                 if (typeof keep == "function") {
                     keep(ev);
                 }
             };
             $(inpu).addClass("text-right");
         });
     }
 </script>

 <?= $this->endSection() ?>