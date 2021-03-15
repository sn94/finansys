<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
APROBACIÓN DE OPERACIÓN Y GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>

<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/generar-vencimiento") ?>">
<input type="hidden" id="INDEX-OPERACIONES" value="<?= base_url('operacion/list') ?>">

<div id="loaderplace">
</div>



<?php
echo form_open("operacion/generar-vencimiento",  ["onsubmit" => "guardar(event)"]);
?>
 
<input type="hidden" name="ESTADO" value="PROCESADO">
<input type="hidden" name="PROCESADO_POR" value="<?=session("ID")?>">

<div class="row mr-md-5 ml-md-5 mb-1" style="background-color: #00968826;">
    <div class="col-12 col-md-4 ">
        <?= view("operacion/forms/form_cliente_view") ?>
    </div>

    <div class="col-12 col-md-4">
        <?= view("operacion/forms/form_opera1") ?>

    </div>
    <div class="col-12 col-md-4 ">
        <?= view("operacion/forms/form_opera2") ?>
    </div>

</div>
<div class="row mr-md-5 ml-md-5 mb-1 pt-2">
    <?= view("operacion/forms/form_codigos") ?>
</div>
<div class="row mr-md-5 ml-md-5 mb-1 text-light pt-2  bg-primary">

    <div class="col-12 col-md-7">
        <?= view("operacion/forms/form_opera3") ?>
        <?= view("operacion/forms/form_opera4") ?>
    </div>

    <div class="col-12 col-md-5 ">
        <h5 class="text-center text-light">GARANTES</h5>
        <?= view("operacion/forms/form_garantes") ?>
    </div>
</div>
<?= view("vencimiento/generacion/create_detail_cuotas") ?>

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


    async function filtrar_operaciones(params) {


        let url_ = $("#INDEX-OPERACIONES").val();
        show_loader();

        let parametros_keys = Object.keys(params);
        let strquery = parametros_keys.map(function(clave) {
            return clave + "=" + params[clave];
        }).join("&");;
        let parametros = strquery;


        let req = await fetch(url_, {
            "method": "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'formato': "json"
            },
            body: parametros
        });
        let json_result = await req.json();
        hide_loader();
        return json_result;

    }

    async function generar_codigo_operacion(esto) {
        let selectedValue = esto == undefined ? $("#LETRAS").val() : esto.value;
        let selectedText = $("#LETRAS option[value=" + selectedValue + "]").text();
        let componentes = selectedText.split("-");
        let letra = componentes[0];
        let numero = componentes[1];
        let corr = isNaN(parseInt(numero) + 1) ? 0 : parseInt(numero) + 1;
        //Ya existe codigo de operacion?
        let coinciden = await filtrar_operaciones({
            LETRA: letra,
            CORRELATIVO: corr
        });

        $("input[name=LETRA]").val(letra);
        $("input[name=CORRELATIVO]").val(corr);

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
        let payload= {CABECERA: cabecera, DETALLE: cuotas_model };
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
            body: JSON.stringify( payload)
        });
        let resp = await req.json();
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


        await obtener_parametros();
        

        calcular_montos();


        mostrarCuotas();

        //Codigo de operacion
        generar_codigo_operacion();

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
                keep(ev);
                calcular_montos();
                mostrarCuotas() ;
            };
            $(inpu).addClass("text-right");
        });
    }
</script>

<?= $this->endSection() ?>