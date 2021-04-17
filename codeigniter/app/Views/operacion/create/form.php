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

        iniciar_calculos_de_operacion();
        //formato entero
        let enteros = document.querySelectorAll(".entero");

       formatoNumerico.formatearCamposNumericos();
       

        //Auto calculo
        let autocalc = document.querySelectorAll("#CREDITO, #NRO_CUOTAS,#SEGURO_CANCEL,#SEGURO_3ROS,#GASTOS_ADM ");
        Array.prototype.forEach.call(autocalc, function(inpu) {

            let keep = inpu.oninput;
            inpu.oninput = function(ev) {


                iniciar_calculos_de_operacion();
                if (typeof keep == "function") {
                    keep(ev);
                }
            };
            $(inpu).addClass("text-right");
        });
    }
</script>

<?= $this->endSection() ?>