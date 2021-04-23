<?php
if (isset($ADICIONAL)) :
?>
  <div class="alert alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong><?= $ADICIONAL ?></strong>
  </div>
<?php
endif;
?>




<style>
  .card-primary:not(.card-outline)>.card-header {
    background-color: #303f9f;
  }
</style>







<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Solicitud</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Laborales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Otros</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" id="family-tab" data-toggle="pill" href="#family-panel" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Familiares</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="referencias-tab" data-toggle="pill" href="#referencias-panel" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Referencias</a>
      </li>
    </ul>
  </div>
  <div class="card-body p-0">
    <div class="tab-content" id="custom-tabs-one-tabContent">

      <div class="tab-pane fade show active p-0" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

        <form id="form-personales" method="POST" action="<?= base_url("deudor/create") ?>" onsubmit="guardar_datos_personales(event)">

          <?php
          $IDNRO =  !isset($deudor_dato) ? "" :   $deudor_dato->IDNRO;
          ?>

          <?= $this->include("deudor/forms/prestamo_form") ?>



          <input class="personal-id" type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
          <?= $this->include("deudor/forms/personales") ?>
          <button type="submit" class="btn btn-primary" id="SUBMIT-PERSONALES"> GUARDAR </button>
        </form>



      </div>

      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

        <form id="FORM-LABORAL" method="POST" action="<?= base_url("deudor/create-ficha-laboral") ?>" onsubmit="guardar_ficha_laboral(event)">
          <?php
          $IDNRO =  !isset($deudor_dato) ? "" :   $deudor_dato->IDNRO;
          ?>
          <input class="personal-id" type="hidden" name="NRO_CLIENTE" value="<?= $IDNRO ?>">
          <input type="hidden" class="PERMITIDO-ENVIO-SOLICI" value="0">

         <div  id="FORM-LABORAL-CONTENT">
         <?= $this->include("deudor/forms/ficha_laboral") ?>
         </div>
          <button type="submit" class="btn btn-primary"> GUARDAR </button>
        </form>

      </div>


      <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
        <form method="POST" action="<?= base_url("deudor/create") ?>" onsubmit="guardar_datos_personales(event)">
          <?php
          $IDNRO =  !isset($deudor_dato) ? "" :   $deudor_dato->IDNRO;
          ?>
          <input class="personal-id" type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
          <input type="hidden" class="PERMITIDO-ENVIO-SOLICI" value="0">


          <?= $this->include("deudor/forms/posesiones") ?>
          <?= $this->include("deudor/forms/otros") ?>
          <button type="submit" class="btn btn-primary"> GUARDAR </button>
        </form>
      </div>


      <div class="tab-pane fade" id="family-panel" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
        <form id="FORM-FAMILIAS" method="POST" action="<?= base_url("deudor/create-ficha-familiar") ?>" onsubmit="guardar_ficha_familiar(event)">
          <?php
          $IDNRO =  !isset($deudor_dato) ? "" :   $deudor_dato->IDNRO;
          ?>
          <input class="personal-id" type="hidden" name="NRO_CLIENTE" value="<?= $IDNRO ?>">
          <input type="hidden" class="PERMITIDO-ENVIO-SOLICI" value="0">

         <div id="FORM-FAMILIAS-CONTENT">
         <?= $this->include("deudor/forms/ficha_familiar") ?>
         </div>

          <button type="submit" class="btn btn-primary"> GUARDAR </button>
        </form>

      </div>


      <div class="tab-pane fade" id="referencias-panel" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
        <form method="POST" action="<?= base_url("deudor/create") ?>" onsubmit="guardar_datos_personales(event)">
          <?php
          $IDNRO =  !isset($deudor_dato) ? "" :   $deudor_dato->IDNRO;
          ?>
          <input class="personal-id" type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
          <input type="hidden" class="PERMITIDO-ENVIO-SOLICI" value="0">

          <?= $this->include("deudor/forms/referencias") ?>
          <button type="submit" class="btn btn-primary"> GUARDAR </button>
        </form>

      </div>
    </div>
  </div>
  <!-- /.card -->
</div>










<script>
  /**INPUT VALIDATION */

  function dar_formato_millares( ar){
    let enpuntos = new Intl.NumberFormat("de-DE").format( ar );
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



  function restaurar_sep_miles() {
    let nro_campos_a_limp = $("[numerico=yes],.numerico").length;

    for (let ind = 0; ind < nro_campos_a_limp; ind++) {
      let valor = $("[numerico=yes],.numerico")[ind].value;
      let valor_forma = dar_formato_millares(valor);
      $("[numerico=yes],.numerico")[ind].value = valor_forma;
    }
    //return val.replaceAll(new RegExp(/[.]*/g), "");
  }

  function limpiar_numeros() {
    let nro_campos_a_limp = $("[numerico=yes],.numerico").length;

    for (let ind = 0; ind < nro_campos_a_limp; ind++) {
      let valor = $("[numerico=yes],.numerico")[ind].value;
      let valor_purifi = valor.replaceAll(new RegExp(/[.]*/g), "");
      $("[numerico=yes],.numerico")[ind].value = valor_purifi;
    }
    //return val.replaceAll(new RegExp(/[.]*/g), "");
  }


  /**END INPUT VALIDATION */



  async function guardar_datos_personales(ev) {

    ev.preventDefault();


    //Desde que formulario?
    if (ev.target.id != "form-personales" && $(".PERMITIDO-ENVIO-SOLICI").val() != 1) return;

    //Cedula obligatoria
    if (ev.target.id == "form-personales" && $("#form-personales input[name=CEDULA]").val() == "") {
      alert("INGRESE EL NRO DE CEDULA");
      return;
    }


    limpiar_numeros();
    $("#SUBMIT-PERSONALES").prop("disabled", true);

    let req = await fetch(ev.target.action, {
      "method": "POST",
      headers: {
        // "Content-Type": "application/json"
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: $(ev.target).serialize()
    });
    let resp = await req.json();

    if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        
        
    $("#SUBMIT-PERSONALES").prop("disabled", false);
    if ("ok" in resp) {
      let id_cliente = resp.ok;
      $(".personal-id").val(id_cliente);
      
      $(".PERMITIDO-ENVIO-SOLICI").val("1");
      
      restaurar_sep_miles();
      alert("Guardado");
    } else {
      alert(resp.error);
    }
  }


   







  window.onload = function() {


    //formato numerico
    let numericos = document.querySelectorAll(".numerico");

    Array.prototype.forEach.call(numericos, function(inpu) {


      inpu.oninput = input_number_millares;
    });



    //habilitar automaticamente todos los formularios si se tratase del modo edicion
    if ($("#form-personales  input[name=IDNRO] ").val() != "")
      $(".PERMITIDO-ENVIO-SOLICI").val("1");

  };
</script>