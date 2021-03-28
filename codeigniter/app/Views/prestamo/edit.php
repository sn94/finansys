<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
ACTUALIZAR OPERACIÓN <?= $prestamo_dato->NRO_OPE?>
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>





<a style="font-weight: 600;" href="<?= base_url("prestamo/index") ?>"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;IR A LISTA DE OPERACIONES</a>



 


<div id="loaderplace">

</div>
<?php
echo form_open(
    "prestamo/edit",
    ["onsubmit" => "guardar(event)"]
);
?>

<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">



<?php
echo view('prestamo/forms/prestamo_form');
?>

<?php
echo view("prestamo/forms/deudor_form");
?>
<?php
echo view("prestamo/forms/garante_form");
?>


<button type="submit" class="btn btn-primary"> GUARDAR</button>

</form>

<script>


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


  
    async function datos_cliente(IDCLIENTE) {

        let resourcePath = "<?= base_url("deudor/get") ?>/" + IDCLIENTE;
        let req = await fetch(resourcePath, {

            headers: {
                formato: "json",
                'X-Requested-With': "XMLHttpRequest"
            }

        });
        let resp = await req.json();
        $("input[name=DEUDOR]").val(resp.IDNRO);
        if( resp.CEDULA != "")
        $("#TITULAR_CI").val(resp.CEDULA);
        else
        $("#TITULAR_CI").val(resp.RUC);
        $("#TITULAR_NOMBRES").val(resp.NOMBRES + " " + resp.APELLIDOS);
        $("#TITULAR_DOMICILIO").val(resp.DOMICILIO);
        $("#TITULAR_OCUPACION").val(resp.OCUPACION);

    }


    //Autocomplete
    async function autocompletado_clientes() {

        let url_ = "<?= base_url("deudor/index/index") ?>";
        //   let termino_busqueda = $("#CLIENTE-SEARCH").val();
        let req = await fetch(url_, {

            headers: {
                formato: "json",
                'X-Requested-With': "XMLHttpRequest"
            }

        });
        let resp = await req.json();
        let dataArray = resp.map(function(value) {
            return {
                label: "( " + value.CEDULA + " )" + value.NOMBRES + " " + value.APELLIDOS,
                value: value.IDNRO
            };
        });



        let elementosCoincidentes = document.querySelector(".cliente");
        new Awesomplete(elementosCoincidentes, {
            minChars: 0,
            list: dataArray,
            // insert label instead of value into the input.
            replace: function(suggestion) {
                // this.input.value = suggestion.label;
                this.input.value= "";
                datos_cliente(suggestion.value);
                // $("input[name=CLIENTE], #CLIENTE-RUC").val(suggestion.value);
            }
        });

    }




    //loader spinner

    function show_loader() {
        let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
        $("#loaderplace").html(loader);
    }

    function hide_loader() {
        $("#loaderplace").html("");
    }





    function limpiar_campos(ev) {

        let elements = ev.target.elements;
        Array.prototype.forEach.call(elements, function(ar) {
            ar.value = "";
        });
    }

    async function guardar(e) {

        e.preventDefault();

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
        hide_loader();


        if ("ok" in resp) {
            new PNotify({
                title: "CÓDIGO DE OPERACIÓN: "+resp.ok,
                text: "",
                type: 'success',
                styling: 'bootstrap3',
                delay: 2000
            });
            limpiar_campos( e);
        } else
            new PNotify({
                title: "ERROR",
                text: resp.error,
                type: 'error',
                styling: 'bootstrap3',
                delay: 2000
            });

    }















    window.onload = function() {
        autocompletado_clientes();
    }
</script>

<?= $this->endSection() ?>