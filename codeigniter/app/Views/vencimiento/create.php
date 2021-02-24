<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
APROBACIÓN DE OPERACIÓN Y GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>




<style>
    #CUOTAS-TABLE tr td,
    #CUOTAS-TABLE tr th {
        padding: 0px;
        margin-right: 0px;
    }


    #CUOTAS-TABLE tr td input {
        border-color: transparent;
    }

    #CUOTAS-TABLE tr>td:nth-child(1) input {
        width: 20px;
    }
</style>




<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/generar-vencimiento") ?>">
<input type="hidden" id="INDEX-OPERACIONES" value="<?= base_url('operacion/list') ?>">


<div id="loaderplace">
</div>

<?php
echo form_open("operacion/generar-vencimiento",  ["onsubmit" => "guardar(event)"]);
?>




<input type="hidden" name="ESTADO" value="PROCESADO">




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

<div class="row mr-md-5 ml-md-5 mb-1 text-light pt-2  bg-primary">

    <div class="col-12 col-md-7">
        <?= view("operacion/forms/form_opera3") ?>
        <?= view("operacion/forms/form_opera4") ?>
    </div>

    <div class="col-12 col-md-5 ">
        <h5 class="text-center">GARANTES</h5>
        <?= view("operacion/forms/form_garantes") ?>

    </div>

</div>



<div class="row mr-md-5 ml-md-5 ">
    <table class="table table-hover  ">
        <thead>
            <tr>
                <th>N°</th>
                <th>VENCIMIENTO</th>
                <th>CUOTA</th>
                <th>DIA</th>
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
<?= view("vencimiento/sistema_frances") ?>
<script>
    /** 
     * generador de cuotas DOM SELECTOR names
     */

    var fecha_inicio_cobro = "#PRIMER_VENCIMIENTO";
    var monto_del_credito = "#CREDITO";
    var nro_de_cuotas = "#NRO_CUOTAS";
    var monto_de_cuota = "#CUOTA_IMPORTE";
    var tabla_dom_id = "#CUOTAS-TABLE";
    var formato_gen_cuotas = "";
    var dias_de_pago = ""; //DOM OBJECT to choose pay days
    var diasDePago = null;



    function calcularInteresCuotas(   args  ) {
        sistemaFrances.init(  args);

        sistemaFrances.generarCuotas();
    }

    function mostrarCuotas() {
        let fechaPrimerVenc = $(fecha_inicio_cobro).val();
        let montoCredito = formValidator.limpiarNumero($("#CREDITO").val());
        let nroCuotas = formValidator.limpiarNumero($("#NRO_CUOTAS").val());
        //PARAMS
        let DA = 300; //dias del anio
        let MA = 12; //Meses del anio
        let DM = 30; //Dias del mes
        let porcentajeInteres = parseFloat(formValidator.limpiarNumero($("#PORCEN_INTERES").val())) / 100;
        let porcentajeIvaInteres = formValidator.limpiarNumero($("#PORCEN_IVA_INTERES").val());
        let netoDesembolsar = formValidator.limpiarNumero($("#CAPITAL_DESEMBOLSO").val());
        let montoDeCuota = formValidator.limpiarNumero($("#CUOTA_IMPORTE").val());

        let calcularInteresParams = {
            DA: DA,
            MA: MA,
            DM: DM,
            CAPITAL: netoDesembolsar,
            NRO_CUOTAS: nroCuotas,
            PORCEN_INTERES: porcentajeInteres,
            PORCEN_IVA: porcentajeIvaInteres
        };
        console.log(calcularInteresParams);
        calcularInteresCuotas(calcularInteresParams);

        return;
        calcVencimientos.init({
            fechaReferencia: fechaPrimerVenc,
            formatoGenCuotas: formato_gen_cuotas,
            montoDeCredito: montoCredito,
            numeroDeCuotas: nroCuotas,
            //   montoDeCuota: montoCuota,
            diasDePago: diasDePago,
            interes: 0.0
        });
        //cuota vencimiento dia
        let detalleGenCuota = calcVencimientos.generarCuotas();

        let createTD = function(name, data, tipo) {
            tipo = tipo == undefined ? "text" : tipo;
            let domobj = "<input  name='" + name + "[]' type='" + tipo + "' readonly  value='" + data + "' >";
            return "<td>" + domobj + "</td>";
        };
        let createTR = function(obj) {

            let tds = Object.keys(obj).map((kname) => {
                if (kname == "VENCIMIENTO") return createTD(kname, obj[kname], "date");
                if (kname == "MONTO") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                return createTD(kname, obj[kname]);
            }).join();
            return "<tr>" + tds + "</tr>";
        };

        detalleGenCuota.forEach(function(cuo) {

            $("#CUOTAS-TABLE").append(createTR(cuo));
        });

    }





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
                //  let truncar= formatoNumerico.darFormatoEnMillares( ar, 4);
                // let cleaned = formValidator.limpiarNumero(  truncar );
                //console.log(  ar, "trunc", truncar, "cleaned", cleaned );
                return parseFloat(arg);
            } catch (err) {
                return 0.0;
            }
        };
        /**Capital NETO A DESEMBOLSAR */
        let monto_ = parsearInt(formValidator.limpiarNumero($("input[name=CREDITO]").val()));
        let seguro_cancel = parsearInt(formValidator.limpiarNumero($("input[name=SEGURO_CANCEL]").val()));
        let seguro_3ros = parsearInt(formValidator.limpiarNumero($("input[name=SEGURO_3ROS]").val()));
        let gastos_adm = parsearInt(formValidator.limpiarNumero($("input[name=GASTOS_ADM]").val()));
        let capital_neto_a_desem = monto_ + seguro_cancel + seguro_3ros + gastos_adm;
        $("#CAPITAL-NETO-DESEMBOLSO").val(formatoNumerico.darFormatoEnMillares(capital_neto_a_desem, 0));
        /**     ***   ***   ***   *** *** ****  */
        /** Monto Total del prestamo mas intereses + IVA */
        let nro_cuotas = parsearInt(formValidator.limpiarNumero($("input[name=NRO_CUOTAS]").val()));
        let interes_porcen = parseFloat(formValidator.limpiarNumero($("#PORCEN_INTERES").val())) / 100; //8 dec

        let intereses = (monto_ * (interes_porcen)) * nro_cuotas;
        let intereses_iva_porce = parseFloat(formValidator.limpiarNumero($("#PORCEN_IVA_INTERES").val())) / 100;
        let iva_intereses = intereses * (intereses_iva_porce);

        let total_prestamo = capital_neto_a_desem + intereses + iva_intereses;
        $("#MONTO-PRESTAMO").val(formatoNumerico.darFormatoEnMillares(total_prestamo, 0));
        $("#INTERESES").val(formatoNumerico.darFormatoEnMillares(intereses, 0));
        $("#INTERES_IVA").val(formatoNumerico.darFormatoEnMillares(iva_intereses, 0));
        /**  */
        /*** Calculo de importe de cuota */

        let importe_de_la_cuota = sistemaFrances.calculaMontoCuota({
            CAPITAL_A_DESENVOL: capital_neto_a_desem,
            TASA_INTERES: interes_porcen,
            NRO_CUOTAS: nro_cuotas
        });


        importe_de_la_cuota = (!isFinite(importe_de_la_cuota) || isNaN(importe_de_la_cuota)) ? 0 : importe_de_la_cuota;
        $("#CUOTA_IMPORTE").val(formatoNumerico.darFormatoEnMillares(importe_de_la_cuota, 0));
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
            };
            $(inpu).addClass("text-right");
        });
    }
</script>

<?= $this->endSection() ?>