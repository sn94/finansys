<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
REGISTRO DE OPERACIÓN
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>


 
<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/pendientes") ?>">

<div id="loaderplace">
</div>

<?php
echo form_open("operacion/create",  ["onsubmit" => "guardar(event)"]);
?>
<?= view("operacion/forms/index") ?>
</form>

<script>
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
        let autocalc = document.querySelectorAll("#CREDITO, #NRO_CUOTAS,#SEGURO_CANCEL,#SEGURO_3ROS,#GASTOS_ADM ");
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