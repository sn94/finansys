<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;
use App\Models\Letras_model;

/*
fuentes de datos 
*/

$EMPRESA = "1"; //Se debe obtener de la sesion
$EMPRESAS =  (new Empresa_model())->list_dropdown();
$LETRAS = (new Letras_model())->list_dropdown();
$FUNCIONARIO = 1;

/**Datos de operacion */

$ID_OPERACION =  isset($OPERACION) ?  $OPERACION->IDNRO :  "";
$NRO_CLIENTE =  isset($OPERACION) ?  $OPERACION->NRO_CLIENTE :  "";
$CEDULA =  isset($OPERACION) ?  $OPERACION->CEDULA :  "";
$NOMBRES =  isset($OPERACION) ?  ($OPERACION->NOMBRES) :  "";
$CREDITO =   isset($OPERACION) ? Utilidades::number_f($OPERACION->CREDITO) :  "0";;
$INTERES =   isset($OPERACION) ? Utilidades::number_f($OPERACION->INTERES) :  "0";;
$INTERES_FINAL =   isset($OPERACION) ? Utilidades::number_f($OPERACION->INTERES_FINAL) :  "0";;
$PRIMER_VENCIMIENTO =   isset($OPERACION) ?  $OPERACION->PRIMER_VENCIMIENTO :  "0";
$CUOTA_IMPORTE =   isset($OPERACION) ?  $OPERACION->CUOTA_IMPORTE :  "0";
$CUOTAS =   isset($OPERACION) ?  $OPERACION->CUOTAS :  "0";
?>



<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
APROBACIÓN DE OPERACIÓN Y GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>


<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/generar-vencimiento") ?>">
<input type="hidden" id="INDEX-OPERACIONES" value="<?= base_url('operacion/list') ?>">
<input type="hidden" id="CUOTA_IMPORTE" value="<?= $CUOTA_IMPORTE ?>">

<div id="loaderplace">
</div>

<?php
echo form_open("operacion/generar-vencimiento",  ["onsubmit" => "guardar(event)"]);
?>



<input type="hidden" name="FUNCIONARIO" value="<?= $FUNCIONARIO ?>">
<input type="hidden" name="ESTADO" value="PROCESADO">




<div class="row mr-md-5 ml-md-5 mb-1" style="background-color: #00968826;">

    <div class="col-12 col-md-4 ">

        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">ID. OPERACIÓN: </label>
            <input readonly style="grid-column-start: 2;" name="IDNRO" type="text" class="form-control" value="<?= $ID_OPERACION ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NRO. CLIENTE: </label>
            <input readonly style="grid-column-start: 2;" name="NRO_CLIENTE" type="text" class="form-control" value="<?= $NRO_CLIENTE ?>">
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
            <label style="grid-column-start: 1;">CRÉDITO: </label>
            <input id="CREDITO" name="CREDITO" style="grid-column-start: 2;" type="text" class="form-control entero" value="<?= $CREDITO ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CUOTAS: </label>
            <input style="grid-column-start: 2;" id="CUOTAS" name="CUOTAS" type="text" class="form-control entero" value="<?= $CUOTAS ?>">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
            <input onchange="generar_cuotas()" style="grid-column-start: 2;" id="PRIMER_VENCIMIENTO" value="<?= $PRIMER_VENCIMIENTO ?>" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
        </div>
    </div>
    <div class="col-12 col-md-4 ">

        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">EMPRESA :</label>
            <?php echo form_dropdown("EMPRESA", $EMPRESAS,  $EMPRESA, ['class' => "form-control"]);  ?>
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">GASTOS ADM.: </label>
            <input style="grid-column-start: 2;" id="GASTOS_ADM" name="GASTOS_ADM" type="text" class="form-control entero" value="0">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CÓDIGO OPERACIÓN: </label>
            <?php echo form_dropdown("", $LETRAS,  '', ['id' => 'LETRAS', 'class' => "form-control", "onchange" => "generar_codigo_operacion(this)"]);  ?>
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">LETRA: </label>
            <input readonly style="grid-column-start: 2;" name="LETRA" type="text" class="form-control">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CORRELATIVO: </label>
            <input readonly style="grid-column-start: 2;" name="CORRELATIVO" type="text" class="form-control">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">N° FACTURA: </label>
            <input maxlength="15" style="grid-column-start: 2;" id="FACTURA" type="text" class="form-control entero">
        </div>
    </div>

    <div class="col-12 col-md-4 text-light bg-primary ">
        <h5 class="text-center">GARANTES</h5>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CI°: </label>
            <input maxlength="10" style="grid-column-start: 2;" name="GARANTE1_CI" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NOMBRES: </label>
            <input maxlength="50" style="grid-column-start: 2;" name="GARANTE1_NOM" type="text" class="form-control">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CI°: </label>
            <input maxlength="10" style="grid-column-start: 2;" name="GARANTE2_CI" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NOMBRES: </label>
            <input maxlength="50" style="grid-column-start: 2;" name="GARANTE2_NOM" type="text" class="form-control">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CI°: </label>
            <input maxlength="10" style="grid-column-start: 2;" name="GARANTE3_CI" type="text" class="form-control entero">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">NOMBRES: </label>
            <input maxlength="50" style="grid-column-start: 2;" name="GARANTE3_NOM" type="text" class="form-control">
        </div>
    </div>

</div>
<div class="row mr-md-5 ml-md-5 ">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>N°</th>
                <th>CUOTA</th>
                <th>VENCIMIENTO</th>
            </tr>
        </thead>
        <tbody id="CUOTAS-TABLE">

        </tbody>
    </table>
</div>



<div class="row mr-md-5 ml-md-5 ">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"> GUARDAR</button>
    </div>
</div>

</form>


<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>
<?= view("vencimiento/calc_vencimientos") ?>
<script>
    /** 
     * generador de cuotas
     */

    var fecha_inicio_cobro = "#PRIMER_VENCIMIENTO";
    var monto_del_credito = "#CREDITO";
    var nro_de_cuotas = "#CUOTAS";
    var monto_de_cuota = "#CUOTA_IMPORTE";
    var tabla_dom_id = "#CUOTAS-TABLE";
    var formato_gen_cuotas = "";
    var dias_de_pago = "";

    function formato_cuotas(key) {
        let evaluado = (key == undefined) ? (formato_gen_cuotas == "" ? "M" : ($(formato_gen_cuotas).val())) : "M";
        let num = 1;
        switch (evaluado) {
            case "D":
                num = 1;
                break; // Para Sumar un dia para generar la siguiente fecha de vencimiento
            case "S":
                num = 7;
                break; //Para Sumar 7dias
            case "Q":
                num = 15;
                break; // Para Sumar 15 dias
            case "M":
                num = 30;
                break; // Para Sumar 30 dias
        }
        return num;
    }



    function es_bisiesto(nu) {
        if (parseInt(nu) % 4 == 0) {
            if (parseInt(nu) % 100 == 0) {
                if (parseInt(nu) % 400 == 0) {
                    return true;
                } else return false;
            } else {
                return true;
            }
        } else return false;
    }


    function obtener_nombre_dia(dia) {
        let dia_semana = "DOMINGO";
        switch (dia) {
            case 0:
                dia_semana = "DOMINGO";
                break;
            case 1:
                dia_semana = "LUNES";
                break;
            case 2:
                dia_semana = "MARTES";
                break;
            case 3:
                dia_semana = "MIERCOLES";
                break;
            case 4:
                dia_semana = "JUEVES";
                break;
            case 5:
                dia_semana = "VIERNES";
                break;
            case 6:
                dia_semana = "SABADO";
                break;
        }
        return dia_semana;
    }

    //Agrupa el numero de dias definidos para pago, ya sea Lunes = 1, Martes= 2, Miercoles= 3, etc.
    function obtener_dias_pago() {

        //Por defecto tomar el dia de fecha de inicio de vencimiento
        let return_default_day = function() {
            let fecha_ini = $(fecha_inicio_cobro).val();

            let dma = fecha_ini.split("-");
            let dia_ = new Date(dma[0], dma[1], dma[2]).getDay();
            return [dia_];
        };

        if (dias_de_pago == "") return return_default_day();

        let los_dias = document.querySelectorAll(dias_de_pago); //"#dias-de-pago input[type=checkbox]"
        if (los_dias.length == 0) return return_default_day();

        let dias_permitidos = Array.prototype.filter.call(los_dias, function(ar) {
            return ar.checked;
        }).map(function(ar) {
            let numero_dia = parseInt(ar.value);
            return numero_dia;
        });
        return dias_permitidos;
    }

    function generar_cuotas() {
        //Asegurar fecha cargada
        if ($(fecha_inicio_cobro).val() == "" || $(fecha_inicio_cobro).val() == undefined) {
            alert("INDICAR FECHA DE INICIO DE COBRO PARA GENERAR LAS CUOTAS");
            return false;
        }
        //Asegurar dias de pago marcados
        if (obtener_dias_pago().length <= 0) {
            alert("MARQUE AL MENOS UN DIA PARA LOS PAGOS");
            document.querySelector(tabla_dom_id).innerHTML = "";
            return false;
        }
        $(tabla_dom_id).html("");
        let fecha_inicio = $(fecha_inicio_cobro).val();
        let montobase = formValidator.limpiarNumero($(monto_del_credito).val());
        let nrocuotas = $(nro_de_cuotas).val();
        let cuotas = formValidator.limpiarNumero($(monto_de_cuota).val());

        //convertir a fecha
        let partes_fecha_base = fecha_inicio.split("-").map(function(ar) {
            return parseInt(ar);
        });

        let fechaBase = new Date(partes_fecha_base[0], partes_fecha_base[1] - 1, partes_fecha_base[2]);

        //limpiar tabla
        $(tabla_dom_id).html("");

        let dia = 1;

        while (dia <= nrocuotas) {

            //Obtener dia mes anio 
            let anio = fechaBase.getFullYear();
            let mes = (fechaBase.getMonth() + 1) < 10 ? "0" + (fechaBase.getMonth() + 1) : (fechaBase.getMonth() + 1);
            let diaa = (fechaBase.getDate()) < 10 ? "0" + (fechaBase.getDate()) : (fechaBase.getDate());
            let vencimiento = anio + "-" + mes + "-" + diaa;
            let formato = formato_cuotas();

            let showvencimiento = "<input readonly type='date' name='DETALLE_VENCIMIENTO[]' value='" + vencimiento + "' >";
            let showcuotas = "<input readonly type='hidden' name='DETALLE_MONTO[]' value='" + cuotas + "' >";

            //Dia de la semana en que cae el vencimiento
            let numeroDia = fechaBase.getDay(); // 1 2 3 4 5 6
            //Es uno de los dias marcados para PAGO ?
            let diasPermitidos = obtener_dias_pago();

            if (diasPermitidos.includes(numeroDia)) {

                let dia_semana = obtener_nombre_dia(numeroDia); //Lunes, Martes, miercoles,etc ...
                $(tabla_dom_id).append("<tr><th scope='row'>" + dia + "</th><td>" + showcuotas + cuotas + "</td><td>" + showvencimiento + "</td><td>" + dia_semana + "</td></tr>");
                //Incrementar fecha
                fechaBase.setDate(fechaBase.getDate() + formato); //La siguiente fecha de vencimiento
                dia++; // Seguir calculando pero para la siguiente cuota

            } else {
                //mantener el contador pero seguir 
                //Incrementando fecha hasta llegar a uno de los dias permitidos
                fechaBase.setDate(fechaBase.getDate() + 1);

            }
        }
        return true;
    }


    /** 
     * end generador de cuotas
     */








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
                text: resp.error,
                type: 'error',
                styling: 'bootstrap3',
                delay: 2000
            });
        }

    }
















    window.onload = function() {


        generar_cuotas();
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