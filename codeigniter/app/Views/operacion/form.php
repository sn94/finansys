<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;

$EMPRESA =   isset($OPERACION) ? $OPERACION->EMPRESA : "1"; //Se debe obtener de la sesion
$EMPRESA_NOM =  (new Empresa_model())->find($EMPRESA)->DESCR;

/**Datos de cliente y su ultima solicitud */

$IDCLIENTE =  isset($CLIENTE) ?  $CLIENTE->IDNRO : (isset($OPERACION) ? $OPERACION->NRO_CLIENTE :   "");
$CEDULA =  isset($CLIENTE) ?  $CLIENTE->CEDULA :  (isset($OPERACION) ? $OPERACION->CEDULA :   "");
$NOMBRES =  isset($CLIENTE) ?  ($CLIENTE->NOMBRES . " " . $CLIENTE->APELLIDOS) :  "";
$MONTO_SOLICITADO =   isset($CLIENTE) ? $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ? $OPERACION->MONTO_SOLICI : "0");
$TIPO_CREDITO =  isset($CLIENTE) ?  $CLIENTE->TIPO_CREDITO : (isset($OPERACION) ?  $OPERACION->TIPO_CREDITO : "");
$CREDITO =  isset($CLIENTE) ?  $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ?  $OPERACION->CREDITO : "");
$PRIMER_VENCIMIENTO =    (isset($OPERACION) ?  $OPERACION->PRIMER_VENCIMIENTO : "");
$INTERES =    (isset($OPERACION) ?  $OPERACION->INTERES : "0");
$INTERES_FINAL =    (isset($OPERACION) ?  $OPERACION->INTERES_FINAL : "0");
$CUOTAS =    (isset($OPERACION) ?  $OPERACION->CUOTAS : "0");
$CUOTA_IMPORTE =    (isset($OPERACION) ?  $OPERACION->CUOTA_IMPORTE : "0");
$INTERES_CUOTA =    (isset($OPERACION) ?  $OPERACION->INTERES_CUOTA : "0");
$SEGURO =    (isset($OPERACION) ?  $OPERACION->SEGURO : "0");
$GASTOS_ADM =    (isset($OPERACION) ?  $OPERACION->GASTOS_ADM : "0");





?>






<input type="hidden" name="EMPRESA" value="<?= $EMPRESA ?>">

<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-1" style="background-color: #00968826;">
    <div class="col-12 col-md-12 p-0">
        <h5 class="bg-primary text-center" style=" color:beige;">EMPRESA: <?= $EMPRESA_NOM ?></h5>
    </div>
    <div class="col-12 col-md-4 ">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NRO. CLIENTE: </label>
            <input readonly style="grid-column-start: 2;" name="NRO_CLIENTE" type="text" class="form-control" value="<?= $IDCLIENTE ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CÉDULA: </label>
            <input readonly style="grid-column-start: 2;" id="CEDULA" type="text" class="form-control" value="<?= $CEDULA ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NOMBRES: </label>
            <input readonly style="grid-column-start: 2;" type="text" class="form-control" value="<?= $NOMBRES ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">MONTO SOLICITADO: </label>
            <input readonly style="grid-column-start: 2;" type="text" class="form-control entero" value="<?= $MONTO_SOLICITADO ?>">
        </div>
    </div>
    <div class="col-12 col-md-4 ">

        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CRÉDITO: </label>
            <input style="grid-column-start: 2;" value="<?= $CREDITO ?>" id="CREDITO" name="CREDITO" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
            <input style="grid-column-start: 2;" value="<?= $PRIMER_VENCIMIENTO ?>" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
        </div>

        <div style="display: grid; grid-template-columns: 50% 50%; ">
            <div class="form-group mr-1" style="grid-column-start: 1;">
                <label>% INT.: </label>
                <input value="<?= $INTERES ?>" id="INTERES" name="INTERES" type="text" class="form-control decimal">
            </div>
            <div class="form-group" style="grid-column-start: 2;">
                <label>% INT.FINAL: </label>
                <input value="<?= $INTERES_FINAL ?>" name="INTERES_FINAL" type="text" class="form-control decimal">
            </div>
        </div>


        <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
            <label style="grid-column-start: 1;">CUOTAS: </label>
            <input style="grid-column-start: 2;" value="<?= $CUOTAS ?>" id="CUOTAS" name="CUOTAS" type="text" class="form-control entero">
        </div>
    </div>
    <div class="col-12 col-md-4 ">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">IMP. CUOTA: </label>
            <input readonly style="grid-column-start: 2;" value="<?= $CUOTA_IMPORTE ?>" name="CUOTA_IMPORTE" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">INTERÉS: </label>
            <input readonly style="grid-column-start: 2;" value="<?= $INTERES_CUOTA ?>" name="INTERES_CUOTA" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">SEGURO: </label>
            <input style="grid-column-start: 2;" value="<?= $SEGURO ?>" id="SEGURO" name="SEGURO" type="text" class="form-control entero" value="0">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">GASTOS ADM.: </label>
            <input style="grid-column-start: 2;" value="<?= $GASTOS_ADM ?>" id="GASTOS_ADM" name="GASTOS_ADM" type="text" class="form-control entero" value="0">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">INTERÉS FINAL: </label>
            <input readonly style="grid-column-start: 2;" value="<?= $INTERES_FINAL ?>" id="INTERES_FINAL" type="text" class="form-control entero">
        </div>
    </div>

</div>





<div class="row mr-md-5 ml-md-5 ">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"> GUARDAR</button>
    </div>
</div>



<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>


<script>



    /**Calculo de intereses   */

    function calcular_montos() {
        let parsearInt = function(arg) {
            try {
                return parseInt(arg);
            } catch (err) {
                return 0;
            }
        };
        let parsearFloat = function(arg) {
            try {
                return parseFloat(arg);
            } catch (err) {
                return 0.0;
            }
        };
        let monto_ = $("input[name=CREDITO]").val();
        let nro_cuotas_ = $("input[name=CUOTAS]").val();
        let interes_porcen_ = $("input[name=INTERES]").val();


        let monto = formValidator.limpiarNumero(monto_);
        let nro_cuotas = formValidator.limpiarNumero(nro_cuotas_);
        let interes_porcen = formValidator.limpiarNumero(interes_porcen_);
        //calc

        let interes_cuota = parsearInt(monto) * (parsearFloat(interes_porcen) / 100);
       
        $("input[name=INTERES_CUOTA]").val(formatoNumerico.darFormatoEnMillares(isNaN(interes_cuota) || !(isFinite(interes_cuota)) ? 0 : interes_cuota));
        let la_cuota = (parsearInt(monto) / parsearInt(nro_cuotas)) + interes_cuota;
        let importe_cuota = $("input[name=CUOTA_IMPORTE]").val(formatoNumerico.darFormatoEnMillares(isNaN(la_cuota) || !(isFinite(la_cuota)) ? 0 : la_cuota));

        //Calcular interes total
        let cuota_con_int = isNaN(la_cuota) || !(isFinite(la_cuota)) ? 0 : la_cuota;
        let seguro = parsearInt(formValidator.limpiarNumero($("input[name=SEGURO]").val()));
        let gastos_adm = parsearInt(formValidator.limpiarNumero($("input[name=GASTOS_ADM]").val()));

        
        let interes_total = cuota_con_int + seguro + gastos_adm;
        $("#INTERES_FINAL").val(formatoNumerico.darFormatoEnMillares(interes_total));

    }
    //loader spinner


    async function guardar(e) {

        e.preventDefault();
        formValidator.init(e.target);

        if (!campos_requeridos()) return;


        let payload = formValidator.getData();
        let endpoint = e.target.action;

        show_loader();

        //deshabilitar temporalmente boton
        $("button[type=submit]").prop("disabled", true);
        let req = await fetch(endpoint, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: payload
        });
        let resp = await req.json();
        //Re habilitar
        $("button[type=submit]").prop("disabled", false);
        //  restaurar_sep_miles();
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
            formValidator.limpiarCampos();
        } else {

            new PNotify({
                title: "ERROR",
                text: resp.error,
                type: 'error',
                styling: 'bootstrap3',
                delay: 2000
            });
        }

    }
</script>