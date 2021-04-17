<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
APROBACIÓN DE OPERACIÓN Y GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>

<!-- LINK AL CUAL SE DEBE DIRECCIONAR AL TERMINAR DE GRABAR -->
<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/generar-vencimiento") ?>">
<!--LISTA LA OPERACIONES DE CREDITO REGISTRADAS PARA OBTENER EL ULTIMO CODIGO Y GENERAR UNO NUEVO,
EL ULTIMO + 1 -->
<input type="hidden" id="INDEX-OPERACIONES" value="<?= base_url('operacion/list') ?>">

<div id="loaderplace">
</div>



<?php
echo form_open("operacion/generar-vencimiento",  ["onsubmit" => "guardar(event)"]);
?>

<!--UNA VEZ APROBADO EL CREDITO CAMBIARA SU ESTADO -->
<input type="hidden" name="ESTADO" value="PROCESADO">
<input type="hidden" name="PROCESADO_POR" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-1" style="background-color: #00968826;">
    <div class="col-12 col-md-4 ">
        <!--DATOS DE CLIENTE (SOLO LECTURA )-->
        <?= view("operacion/forms/form_cliente_view") ?>
    </div>

    <div class="col-12 col-md-4">
        <!-- VIEW:  monto de credito , numero de cuotas y fecha de primer vencimiento -->
        <?= view("operacion/forms/form_data_principal") ?>

    </div>
    <div class="col-12 col-md-4 ">
        <!-- VIEW: Gastos administrativos, seguro de cancelacion, seguro de terceros -->
        <?= view("operacion/forms/form_seguro_gasto") ?>
    </div>

</div>
<div class="row mr-md-5 ml-md-5 mb-1 pt-2">
    <!-- VIEW: Codigo de operacion, empresa encargada, numero de factura -->
    <?= view("operacion/forms/form_codigos") ?>
</div>
<div class="row mr-md-5 ml-md-5 mb-1 text-light pt-2  bg-primary">

    <div class="col-12 col-md-7">
        <!-- VIEW: parametros de total en intereses, total IVA de intereses, porcentaje de interes y  porcentaje de IVA -->
        <?= view("operacion/forms/form_intereses") ?>
        <!-- VIEW: monto final del prestamo, capital neto a desembolsar, importe de la cuota      -->
        <?= view("operacion/forms/form_montos_calculados") ?>
    </div>

    <div class="col-12 col-md-5 ">
        <h5 class="text-center text-light">GARANTES</h5>
        <?= view("operacion/forms/form_garantes") ?>
    </div>
</div>

<?= view("aprobacion/create_detail_cuotas") ?>

<div class="row mr-md-5 ml-md-5 ">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"> GUARDAR</button>
    </div>
</div>
</form>





<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>

<?= view("operacion/js/calculador_montos") ?>

<script>
    async function generar_codigo_operacion(esto) {
        let selectedValue = esto == undefined ? $("#LETRAS").val() : esto.value;
        let selectedText = $("#LETRAS option[value=" + selectedValue + "]").text();
        let componentes = selectedText.split("-");
        let letra = componentes[0];
        let nuevoCodigo = await fetch("<?= base_url("operacion/generar_codigo_operacion") ?>/" + letra);
        let letra_corre = await nuevoCodigo.json();
        if(  "auth_error" in letra_corre )
        {
            alert(  letra_corre.auth_error );
            window.location=  letra_corre.redirect;
        }
        

        $("input[name=LETRA]").val(letra_corre.LETRA);
        $("input[name=CORRELATIVO]").val(letra_corre.CORRELATIVO);
    }



    //loader spinner

    function show_loader() {
        let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
        $("#loaderplace").html(loader);
    }

    function hide_loader() {
        $("#loaderplace").html("");
    }


    /**Form */



    async function guardar(e) {

        e.preventDefault();

        formValidator.init(e.target);
        let cabecera = formValidator.getData("application/json");
        let payload = {
            CABECERA: cabecera,
            DETALLE: cuotas_model
        };
        let endpoint = e.target.action;

        show_loader();

        //deshabilitar temporalmente boton
        $("button[type=submit]").prop("disabled", true);
        let req = await fetch(endpoint, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });
        let resp = await req.json();
        if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        

        //Re habilitar
        $("button[type=submit]").prop("disabled", false);

        hide_loader();


        if ("ok" in resp) {
            let ir_a = $("#OPERACIONES-INDEX").val();
            window.location = ir_a;

            new PNotify({
                title: "OPERACIÓN REGISTRADA ",
                text: "",
                type: 'success',
                styling: 'bootstrap3',
                delay: 2000
            });

        } else {

            new PNotify({
                title: "ERROR",
                text: resp.err,
                type: 'error',
                styling: 'bootstrap3',
                delay: 2000
            });
        }

    }






    window.onload = async function() {

      //  await obtener_parametros();
        iniciar_calculos_de_operacion();

        mostrarCuotas();
        //Codigo de operacion
        generar_codigo_operacion();

        //formato numerico
        formatoNumerico.formatearCamposNumericos();
        //Auto calculo
        let autocalc = document.querySelectorAll("#CREDITO, #NRO_CUOTAS,#SEGURO_CANCEL,#SEGURO_3ROS,#GASTOS_ADM ");
        Array.prototype.forEach.call(autocalc, function(inpu) {
            let keep = inpu.oninput;

            inpu.oninput = function(ev) {
                if (typeof keep == "function")
                    keep(ev);
                iniciar_calculos_de_operacion();
                mostrarCuotas();
            };
            $(inpu).addClass("text-right");
        });
    }
</script>

<?= $this->endSection() ?>