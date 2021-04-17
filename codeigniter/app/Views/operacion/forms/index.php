<style>
    input[readonly] {
        background-color: #3f51b5 !important;
        color: black !important;
    }
</style>





<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-0 pt-0" style="background-color: #00968826;">

    <div class="col-12 col-md-12 p-0 bg-primary"><?= view("operacion/forms/form_header") ?></div>



    <div class="col-12 col-md-4 pt-1">
        <?= view("operacion/forms/form_data_principal") ?>
    </div>
    <div class="col-12 col-md-4 pt-1 bg-primary" id="FICHA-CLIENTE">

        <?= view("operacion/forms/form_cliente_view",  ['CLIENTE'=>  $CLIENTE]) ?>
    </div>
    <div class="col-12 col-md-4 bg-primary  pt-1">
        <?= view("operacion/forms/form_seguro_gasto") ?>
    </div>
</div>

<div class="row mr-md-5 ml-md-5 mb-1 pt-2 mt-0 bg-primary">
    <div class="col-12 col-md-5 ">

        <?= view("operacion/forms/form_intereses") ?>
    </div>
    <div class="col-12 col-md-5">
        <?= view("operacion/forms/form_montos_calculados") ?>
    </div>
    <div class="col-12 col-md-2 ">
        <div class="row mr-md-5 ml-md-5 ">
            <div class="col-12">
                <button id="BOTON-ENVIO" type="submit" class="btn btn-success"> GUARDAR</button>
            </div>
        </div>
    </div>
</div>







<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>

<?= view("operacion/js/calculador_montos") ?>
<script>
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



    async function guardar(e) {

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
        if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
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
</script>