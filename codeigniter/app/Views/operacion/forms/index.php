


<style>
    input[readonly] {
        background-color: #3f51b5 !important;
        color: black !important;
    }
</style>





<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-0 pt-0" style="background-color: #00968826;">

    <div class="col-12 col-md-12 p-0 bg-primary"><?= view("operacion/forms/form_header") ?></div>

    <div class="col-12 col-md-4 pt-1 bg-primary" id="FICHA-CLIENTE">

        <?= view("operacion/forms/form_cliente_view") ?>
    </div>

    <div class="col-12 col-md-4 pt-1">
        <?= view("operacion/forms/form_opera1") ?>
    </div>
    <div class="col-12 col-md-4 pt-1">
        <?= view("operacion/forms/form_opera2") ?>
    </div>
</div>

<div class="row mr-md-5 ml-md-5 mb-1 pt-2 mt-0 bg-primary">
    <div class="col-12 col-md-5 ">

    <?= view("operacion/forms/form_opera3") ?>
    </div>
    <div class="col-12 col-md-5">
    <?= view("operacion/forms/form_opera4") ?>
    </div>
    <div class="col-12 col-md-2 ">
        <div class="row mr-md-5 ml-md-5 ">
            <div class="col-12">
                <button type="submit" class="btn btn-success"> GUARDAR</button>
            </div>
        </div>
    </div>
</div>







<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>
<?= view("vencimiento/sistema_frances") ?>

<script>
    var parametrosCalc = {};


    async function obtener_parametros() {

        let url__ = "<?= base_url("parametros/get") ?>";
        let req = await fetch(url__);
        let resp = await req.json();
        parametrosCalc = resp;

        let BCP_PORCEN = Math.round((parseFloat(formValidator.limpiarNumero(parametrosCalc.BCP_INTERES)) / 12) * 1e8) / 1e8;

        $("#PORCEN_INTERES").val(formatoNumerico.darFormatoEnMillares(BCP_PORCEN, 8));

        $("#PORCEN_IVA_INTERES").val(parametrosCalc.IVA);
    }




    
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
        $("#CAPITAL_DESEMBOLSO").val(formatoNumerico.darFormatoEnMillares(capital_neto_a_desem, 0));
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