<?php

use App\Helpers\Utilidades;

$IDNRO =  !isset($dato) ? "" :   $dato->IDNRO; 
$BCP_INTERES =  !isset($dato) ? "0,0" :  $dato->BCP_INTERES;
$SALARIO_MIN =  !isset($dato) ? "0" : $dato->SALARIO_MIN;
$JORNAL_MIN =  !isset($dato) ? "0" : $dato->JORNAL_MIN;
$IVA =  !isset($dato) ? "0" :     $dato->IVA;  
?>

<?php if (isset($dato)) : ?>
  <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
<?php endif; ?>


<div class="container-fluid col-12 col-md-3">

  


    <div style="display: flex; flex-direction: column;">
      <label>% INTERÉS BCP:</label>
      <input name="BCP_INTERES" type="text" class="form-control decimal" value="<?= $BCP_INTERES ?>">
    </div>
    <div style="display: flex; flex-direction: column;">
      <label>SALARIO MÍNIMO:</label>
      <input name="SALARIO_MIN" type="text" class="form-control entero" value="<?= $SALARIO_MIN ?>">
    </div>
 
    <div style="display: flex; flex-direction: column;">
      <label>JORNAL MÍNIMO:</label>
      <input name="JORNAL_MIN" type="text" class="form-control entero" value="<?= $JORNAL_MIN ?>">
    </div> 
   

    <div style="display: flex; flex-direction: column;">
      <label>% I.V.A:</label>
      <input name="IVA" type="text" class="form-control decimal" value="<?= $IVA ?>">
    </div>

    <?php if (!isset($vista)) : ?>
    <div class="col-12 col-md-6">
      <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
  <?php endif; ?>

  </div>  

<?= view("validations/formato_numerico") ?>
<?= view("validations/form_validate") ?>

<script>
  async function guardar(ev) {
    ev.preventDefault();
    formValidator.init(ev.target);

    let req = await fetch(ev.target.action, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'CHECK-AUTH': 'S'
      },
      body: formValidator.getData()
    });
    let resp = await req.json();
    if ("auth_error" in resp) {
      alert(resp.auth_error);
      window.location = resp.redirect;
    }


    if ("ok" in resp) {

      // formValidator.limpiarCampos();
      // restaurar_sep_miles();
      alert("Guardado");
    } else {
      // restaurar_sep_miles();
      alert(resp.error);
    }

  }




  window.onload = function() {

    //formato entero
    let enteros = document.querySelectorAll(".entero");
    Array.prototype.forEach.call(enteros, function(inpu) {
      inpu.oninput = formatoNumerico.formatearEntero;
    });


    let decimales = document.querySelectorAll(".decimal");
    Array.prototype.forEach.call(decimales, function(inpu) {
      inpu.oninput = formatoNumerico.formatearDecimal;
    });


  };
</script>