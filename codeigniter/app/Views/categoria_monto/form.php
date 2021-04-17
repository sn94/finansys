<?php

use App\Helpers\Utilidades;
?>

<div id="loaderplace">
</div>
<div class="row">

  <div class="col-12 col-md-2">
    <label>MONTO:</label>
    <input maxlength="10" oninput="input_number_millares(event)" name="MONTO" type="text" class="form-control numerico" value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->MONTO) ?>">

  </div>


  <div class="col-12 col-md-2">
    <label>NRO DE CUOTAS:</label>
    <input maxlength="10" oninput="input_number_millares(event)" name="NRO_CUOTAS" type="text" class="form-control numerico" value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->NRO_CUOTAS) ?>">

  </div>

  <div class="col-12 col-md-2">

    <label>CUOTA:</label>
    <input maxlength="10" oninput="input_number_millares(event)" name="CUOTA" type="text" class="form-control numerico" value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->CUOTA) ?>">

  </div>

  <div class="col-12 col-md-3">

    <label>FORMATO:</label>
    <select name="FORMATO" class="form-control">

      <option value="D">DIARIO</option>
      <option value="S">SEMANAL</option>
      <option value="Q">QUINCENAL</option>
      <option value="M">MENSUAL</option>
    </select>
  </div>

  <div class="col-12 col-md-3">
    <label for="">%INT. SOBRE CAPITAL:</label>
    <input type="text" name="INT_PORCE" readonly value="0.0" class="form-control">
  </div>
</div>

<div class="container d-flex align-self-center">

  <?php if (!isset($vista)) : ?>

    <button type="submit" class="btn btn-primary">GUARDAR</button>

  <?php endif; ?>




</div>

<script>
  function calc_porce_interes() {
    let capital = $("input[name=MONTO]").val() == "" ? 0 : parseInt(quitarSeparador($("input[name=MONTO]").val()));
    let cuota = $("input[name=NRO_CUOTAS]").val() == "" ? 0 : parseInt(quitarSeparador($("input[name=NRO_CUOTAS]").val()));
    let monto_cuot = $("input[name=CUOTA]").val() == "" ? 0 : parseInt(quitarSeparador($("input[name=CUOTA]").val()));
    let capital_f = cuota * monto_cuot;
    let tot_int = capital_f - capital;

    let interes_p = (tot_int) / (capital * cuota);
    let redondeo = new Intl.NumberFormat("en", {
      maximumFractionDigits: 3,
      useGrouping: false
    }).format(interes_p);
    $("input[name=INT_PORCE]").val(redondeo);



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


  function restaurar_sep_miles() {
         let nro_campos_a_limp = $("[numerico=yes]").length;

         for (let ind = 0; ind < nro_campos_a_limp; ind++) {
             let valor = $("[numerico=yes]")[ind].value;
             let valor_forma = dar_formato_millares(valor);
             $("[numerico=yes]")[ind].value = valor_forma;
         }
         //return val.replaceAll(new RegExp(/[.]*/g), "");
     }

     function limpiar_numeros() {
         let nro_campos_a_limp = $("[numerico=yes]").length;

         for (let ind = 0; ind < nro_campos_a_limp; ind++) {
             let valor = $("[numerico=yes]")[ind].value;
             let valor_purifi = valor.replaceAll(new RegExp(/[.]*/g), "");
             $("[numerico=yes]")[ind].value = valor_purifi;
         }
         //return val.replaceAll(new RegExp(/[.]*/g), "");
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
    if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        
        
    //Re habilitar
    $("button[type=submit]").prop("disabled", false);
    hide_loader();


    if ("ok" in resp) {
      act_grilla();
      limpiar_numeros();
      limpiar_campos(e);
    } else
      alert(resp.error);

  }
</script>