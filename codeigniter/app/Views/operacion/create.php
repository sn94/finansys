<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;

$EMPRESA = "1"; //Se debe obtener de la sesion
$EMPRESA_NOM =  (new Empresa_model())->find($EMPRESA)->DESCR;

/**Datos de cliente y su ultima solicitud */

$IDCLIENTE =  isset($CLIENTE) ?  $CLIENTE->IDNRO :  "";
$CEDULA =  isset($CLIENTE) ?  $CLIENTE->CEDULA :  "";
$NOMBRES =  isset($CLIENTE) ?  ($CLIENTE->NOMBRES . " " . $CLIENTE->APELLIDOS) :  "";
$MONTO_SOLICITADO =   isset($CLIENTE) ? Utilidades::number_f($CLIENTE->MONTO_SOLICI) :  "0";
$TIPO_CREDITO =  isset($CLIENTE) ?  $CLIENTE->TIPO_CREDITO :  "";
?>
<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
REGISTRO DE OPERACIÓN
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>






<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/index") ?>">


<div id="loaderplace">

</div>
<?php
echo form_open("operacion/create",  ["onsubmit" => "guardar(event)"]);
?>


<input type="hidden" name="EMPRESA" value="<?= $EMPRESA ?>">

<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">



<div class="row mr-md-5 ml-md-5 mb-1" style="background-color: #00968826;">
    <div class="col-12 col-md-12 p-0">
        <h5 style="background-color: #00796b; color:beige;" class="text-center">EMPRESA: <?= $EMPRESA_NOM ?></h5>
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
            <input readonly style="grid-column-start: 2;" type="text" class="form-control numerico" value="<?= $MONTO_SOLICITADO ?>">
        </div>
    </div>
    <div class="col-12 col-md-4 ">

        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CRÉDITO: </label>
            <input style="grid-column-start: 2;" id="CREDITO" name="CREDITO" type="text" class="form-control numerico">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
            <input style="grid-column-start: 2;" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
        </div>

        <div style="display: grid; grid-template-columns: 50% 50%; ">
            <div class="form-group mr-1" style="grid-column-start: 1;">
                <label>% INT.: </label>
                <input id="INTERES" name="INTERES" type="text" class="form-control decimal">
            </div>
            <div class="form-group" style="grid-column-start: 2;">
                <label>% INT.FINAL: </label>
                <input name="INTERES_FINAL" type="text" class="form-control decimal">
            </div>
        </div>


        <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
            <label style="grid-column-start: 1;">CUOTAS: </label>
            <input style="grid-column-start: 2;" id="CUOTAS" name="CUOTAS" type="text" class="form-control numerico">
        </div>
    </div>
    <div class="col-12 col-md-4 ">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">IMP. CUOTA: </label>
            <input readonly style="grid-column-start: 2;" name="CUOTA_IMPORTE" type="text" class="form-control numerico">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">INTERÉS: </label>
            <input readonly style="grid-column-start: 2;" name="INTERES_CUOTA" type="text" class="form-control numerico">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">SEGURO: </label>
            <input style="grid-column-start: 2;" id="SEGURO" name="SEGURO" type="text" class="form-control numerico" value="0">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">GASTOS ADM.: </label>
            <input style="grid-column-start: 2;" id="GASTOS_ADM" name="GASTOS_ADM" type="text" class="form-control numerico" value="0">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">INTERÉS FINAL: </label>
            <input readonly style="grid-column-start: 2;" id="INTERES_FINAL" type="text" class="form-control numerico">
        </div>
    </div>

</div>





<div class="row mr-md-5 ml-md-5 ">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"> GUARDAR</button>
    </div>
</div>

</form>

<script>
    /** Formato numerico y decimal  * */


    function restaurar_sep_miles() {
        let nro_campos_a_limp = $("[numerico=yes], .numerico").length;

        for (let ind = 0; ind < nro_campos_a_limp; ind++) {
            let valor = $("[numerico=yes], .numerico")[ind].value;
            let valor_forma = dar_formato_millares(valor);
            $("[numerico=yes], .numerico")[ind].value = valor_forma;
        }
        //decimales
        let decimales = document.querySelectorAll(".decimal");
        Array.prototype.forEach.call(decimales, function(inpu) {
            let nuevo = inpu.value.replace(",", ".");
            inpu.value = dar_formato_millares(nuevo);
            $(inpu).addClass("text-right");
        });


        //return val.replaceAll(new RegExp(/[.]*/g), "");
    }

    function limpiar_numero(val) {
        if (/,+/.test(val))
            return val.replaceAll(new RegExp(/[.]*/g), "").replace(",", ".");
        else
            return val.replaceAll(new RegExp(/[.]*/g), "");

    }

    function limpiar_numeros() {
        let nro_campos_a_limp = $("[numerico=yes],.numerico,.decimal").length;

        for (let ind = 0; ind < nro_campos_a_limp; ind++) {
            let valor = $("[numerico=yes],.numerico,.decimal")[ind].value;
            let valor_purifi = limpiar_numero(valor);
            $("[numerico=yes],.numerico,.decimal")[ind].value = valor_purifi;
        }
        //return val.replaceAll(new RegExp(/[.]*/g), "");
    }



    function dar_formato_millares(ar) {
        let enpuntos = new Intl.NumberFormat("de-DE").format(ar);
        return enpuntos;
    }

    function input_number_millares(ev) {
        if (ev.data != undefined) {
            if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
                ev.target.value =
                    ev.target.value.substr(0, ev.target.selectionStart - 1) +
                    ev.target.value.substr(ev.target.selectionStart);
            }
        }
        //Formato de millares
        let val_Act = ev.target.value;
        val_Act = val_Act.replaceAll(new RegExp(/[\.]*[,]*/g), "");
        let enpuntos = new Intl.NumberFormat("de-DE").format(val_Act);
        $(ev.target).val(enpuntos);
    }



    function formatear_decimal(ev) { //

        let limpiar_numero_para_float = function(val) {
            return val.replaceAll(new RegExp(/[.]*/g), "").replaceAll(new RegExp(/[,]{1}/g), ".");
        };
        if (ev.data != undefined) {
            if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
                let noEsComa = ev.data.charCodeAt() != 44;
                let yaHayComa = ev.data.charCodeAt() == 44 && /(,){1}/.test(ev.target.value.substr(0, ev.target.value.length - 2));
                let yaHayComa2 = ev.data.charCodeAt() == 44 && /(,){2}/.test(ev.target.value);

                let comaPrimerLugar = ev.data.charCodeAt() == 44 && ev.target.value.length == 1;
                let comaDespuesDePunto = ev.data.charCodeAt() == 44 && /\.{1},{1}/.test(ev.target.value);
                if (noEsComa || yaHayComa2 || (yaHayComa || comaPrimerLugar || comaDespuesDePunto)) {
                    ev.target.value = ev.target.value.substr(0, ev.target.selectionStart - 1) + ev.target.value.substr(ev.target.selectionStart);
                    return;
                } else return;
            }
        }

        if (ev.data == undefined) {
            let solo_decimal = limpiar_numero_para_float(ev.target.value);
            let float__ = parseFloat(solo_decimal);
            let enpuntos = dar_formato_millares(float__);
            if (!(isNaN(enpuntos)))
                $(ev.target).val(enpuntos);
            return;
        }

        //convertir a decimal
        //dejar solo la coma decimal pero como punto 
        let solo_decimal = limpiar_numero_para_float(ev.target.value);
        let noEsComaOpunto = ev.data.charCodeAt() != 44 && ev.data.charCodeAt() != 46;
        if (noEsComaOpunto) {
            let float__ = parseFloat(solo_decimal);

            //Formato de millares 
            let enpuntos = dar_formato_millares(float__);
            if (!(isNaN(enpuntos)))
                $(ev.target).val(enpuntos);
        }
    }




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


        let monto = limpiar_numero(monto_);
        let nro_cuotas = limpiar_numero(nro_cuotas_);
        let interes_porcen = limpiar_numero(interes_porcen_);
        //calc

        let interes_cuota = parsearInt(monto) * (parsearFloat(interes_porcen) / 100);
        console.log(interes_cuota);
        $("input[name=INTERES_CUOTA]").val(dar_formato_millares(isNaN(interes_cuota) || !(isFinite(interes_cuota)) ? 0 : interes_cuota));
        let la_cuota = (parsearInt(monto) / parsearInt(nro_cuotas)) + interes_cuota;
        let importe_cuota = $("input[name=CUOTA_IMPORTE]").val(dar_formato_millares(isNaN(la_cuota) || !(isFinite(la_cuota)) ? 0 : la_cuota));

        //Calcular interes total
        let cuota_con_int = isNaN(la_cuota) || !(isFinite(la_cuota)) ? 0 : la_cuota;
        let seguro = parsearInt(limpiar_numero($("input[name=SEGURO]").val()));
        let gastos_adm = parsearInt(limpiar_numero($("input[name=GASTOS_ADM]").val()));

        console.log(cuota_con_int, seguro, gastos_adm);
        let interes_total = cuota_con_int + seguro + gastos_adm;
        $("#INTERES_FINAL").val(dar_formato_millares(interes_total));

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


    function limpiar_campos(ev) {

        let elements = ev.target.elements;
        Array.prototype.forEach.call(elements, function(ar) {
            ar.value = "";
        });
    }


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

    async function guardar(e) {

        e.preventDefault();
        if (!campos_requeridos()) return;
        limpiar_numeros();

        let payload = $(e.target).serialize();
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
        restaurar_sep_miles();
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
            limpiar_campos(e);
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
















    window.onload = function() {
        //formato numerico
        let numericos = document.querySelectorAll(".numerico");
        Array.prototype.forEach.call(numericos, function(inpu) {

            inpu.oninput = input_number_millares;
            $(inpu).addClass("text-right");
        });
        //formato con coma decimal
        let decimales = document.querySelectorAll(".decimal");
        Array.prototype.forEach.call(decimales, function(inpu) {
            inpu.oninput = formatear_decimal;
            $(inpu).addClass("text-right");
        });



        //Auto calculo
        let autocalc = document.querySelectorAll("#CREDITO, #INTERES, #CUOTAS,#SEGURO,#GASTOS_ADM ");
        Array.prototype.forEach.call(autocalc, function(inpu) {
            let keep = inpu.oninput;

            inpu.oninput = function(ev) {
                keep(ev);
                calcular_montos();
            };
            $(inpu).addClass("text-right");
        });
    }
</script>

<?= $this->endSection() ?>