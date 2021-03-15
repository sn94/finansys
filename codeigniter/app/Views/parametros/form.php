<?php

use App\Helpers\Utilidades;

$IDNRO =  !isset($dato) ? "" :   $dato->IDNRO;
$BCP_INTERES =  !isset($dato) ? "0,0" :  $dato->BCP_INTERES ;
$SALARIO_MIN =  !isset($dato) ? "0" : $dato->SALARIO_MIN  ;
$JORNAL_MIN =  !isset($dato) ? "0" : $dato->JORNAL_MIN;
$GAST_ADM_PORCE =  !isset($dato) ? "0,0" :  $dato->GAST_ADM_PORCE ;
$DIASXMES =   !isset($dato) ? "30" :   $dato->DIASXMES;
$DIASXANIO =  !isset($dato) ? "300" :   $dato->DIASXANIO;
$IVA =  !isset($dato) ? "0" :     $dato->IVA ;
$MESESXANIO =  !isset($dato) ? "12" :   $dato->MESESXANIO;
$SEGURO_CANCEL =  !isset($dato) ? "0" :   $dato->SEGURO_CANCEL;
$SEGURO_3ROS =  !isset($dato) ? "0" :   $dato->SEGURO_3ROS;
$MORA_PORCE =  !isset($dato) ? "0" :  ( $dato->MORA_PORCE =="" ?  "0" :   $dato->MORA_PORCE );
$PUNITORIO_PORCE =  !isset($dato) ? "0" :  ( $dato->PUNITORIO_PORCE =="" ?  "0" :   $dato->PUNITORIO_PORCE );
?>

<input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">


<div class="row">

  <div class="col-12 col-md-6">

    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">% INTERÉS BCP:</label>
      <input style="grid-column-start: 2;" name="BCP_INTERES" type="text" class="form-control decimal" value="<?= $BCP_INTERES ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">SALARIO MÍNIMO:</label>
      <input style="grid-column-start: 2;" name="SALARIO_MIN" type="text" class="form-control entero" value="<?= $SALARIO_MIN ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">JORNAL MÍNIMO:</label>
      <input style="grid-column-start: 2;" name="JORNAL_MIN" type="text" class="form-control entero" value="<?= $JORNAL_MIN ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">% GASTOS ADM.:</label>
      <input style="grid-column-start: 2;" name="GAST_ADM_PORCE" type="text" class="form-control decimal" value="<?= $GAST_ADM_PORCE ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">SEGURO DE CANCELACIÓN:</label>
      <input style="grid-column-start: 2;" name="SEGURO_CANCEL" type="text" class="form-control entero" value="<?= $SEGURO_CANCEL ?>">
    </div>

    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">% MORA:</label>
      <input style="grid-column-start: 2;" name="MORA_PORCE" type="text" class="form-control decimal" value="<?= $MORA_PORCE ?>">
    </div>

  </div>

  <div class="col-12 col-md-6">
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">DIAS P/MES:</label>
      <input maxlength="2" style="grid-column-start: 2;" name="DIASXMES" type="text" class="form-control entero" value="<?= $DIASXMES ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">DIAS P/AÑO:</label>
      <input maxlength="3" style="grid-column-start: 2;" name="DIASXANIO" type="text" class="form-control entero" value="<?= $DIASXANIO ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">% I.V.A:</label>
      <input style="grid-column-start: 2;" name="IVA" type="text" class="form-control decimal" value="<?= $IVA ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">MESES P/AÑO:</label>
      <input maxlength="2" style="grid-column-start: 2;" name="MESESXANIO" type="text" class="form-control entero" value="<?= $MESESXANIO ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">SEGURO A NOM. DE 3ROS.:</label>
      <input style="grid-column-start: 2;" name="SEGURO_3ROS" type="text" class="form-control entero" value="<?= $SEGURO_3ROS ?>">
    </div>
    <div style="display: grid;  grid-template-columns: 30% 70% ;">
      <label style="grid-column-start: 1;">% PUNITORIO:</label>
      <input style="grid-column-start: 2;" name="PUNITORIO_PORCE" type="text" class="form-control decimal" value="<?= $PUNITORIO_PORCE ?>">
    </div>

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
    formValidator.init( ev.target);
   
    let req = await fetch(ev.target.action, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body:   formValidator.getData()
    });
    let resp = await req.json();
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