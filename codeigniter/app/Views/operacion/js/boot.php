<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>
<?= view("operacion/js/calculador_montos") ?>
<script>
    function show_loader() {
        let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
        $("#loaderplace").html(loader);
    }

    function hide_loader() {
        $("#loaderplace").html("");
    }


    function inicializarAreaOperacion() {

        cambiarSistema();
        //   iniciar_calculos_de_operacion();
        //formato entero
        let enteros = document.querySelectorAll(".entero");

        formatoNumerico.formatearCamposNumericos();


        //Auto calculo
        let autocalc = document.querySelectorAll("#CREDITO, #NRO_CUOTAS,#SEGURO_CANCEL,#SEGURO_3ROS,#GASTOS_ADM ");
        Array.prototype.forEach.call(autocalc, function(inpu) {

            let keep = inpu.oninput;
            inpu.oninput = function(ev) {


                cambiarSistema();
                if (typeof keep == "function") {
                    keep(ev);
                }
            };
            $(inpu).addClass("text-right");
        });
    }


    async function generar_codigo_operacion(esto) {
        let selectedValue = esto == undefined ? $("#LETRAS").val() : esto.value;
        let selectedText = $("#LETRAS option[value=" + selectedValue + "]").text();
        let componentes = selectedText.split("-");
        let letra = componentes[0];
        let nuevoCodigo = await fetch("<?= base_url("operacion/generar_codigo_operacion") ?>/" + letra);
        let letra_corre = await nuevoCodigo.json();
        if ("auth_error" in letra_corre) {
            alert(letra_corre.auth_error);
            window.location = letra_corre.redirect;
        }


        $("input[name=LETRA]").val(letra_corre.LETRA);
        $("input[name=CORRELATIVO]").val(letra_corre.CORRELATIVO);
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
        if ($("#NRO_CUOTAS").val() == "" || $("#NRO_CUOTAS").val() == "0") {
            alert("INGRESE NRO DE CUOTAS");
            return false;
        }
        return true;
    }



    async function guardarOperacion(e) {

        e.preventDefault();
        if (!campos_requeridos()) return;

        $("#BOTON-ENVIO").prop("disabled", true);

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
        if ("auth_error" in resp) {
            alert(resp.auth_error);
            window.location = resp.redirect;
        }


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
        $("#BOTON-ENVIO").prop("disabled", false);

    }




    async function guardarAprobacionOperacion(e) {

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
        if ("auth_error" in resp) {
            alert(resp.auth_error);
            window.location = resp.redirect;
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
</script>