<?php

use App\Helpers\Utilidades;

$IDNRO =  !isset($dato) ? "" :   $dato->IDNRO;
$CODIGO_PRODUCTO =  !isset($dato) ? "" :  $dato->CODIGO_PRODUCTO;
$DESCRIPCION =  !isset($dato) ? "" :  $dato->DESCRIPCION;
$INTERES_PORCE =  !isset($dato) ? "0,0" :  $dato->INTERES_PORCE;
$DIAS_SIN_INTERES =  !isset($dato) ? "0" :  $dato->DIAS_SIN_INTERES;
$GAST_ADM_PORCE =  !isset($dato) ? "0,0" :  $dato->GAST_ADM_PORCE;
$DIASXMES =   !isset($dato) ? "30" :   $dato->DIASXMES;
$DIASXANIO =  !isset($dato) ? "300" :   $dato->DIASXANIO;
$MESESXANIO =  !isset($dato) ? "12" :   $dato->MESESXANIO;
$SEGURO_CANCEL =  !isset($dato) ? "0" :   $dato->SEGURO_CANCEL;
$SEGURO_3ROS =  !isset($dato) ? "0" :   $dato->SEGURO_3ROS;
$MORA_PORCE =  !isset($dato) ? "0" : ($dato->MORA_PORCE == "" ?  "0" :   $dato->MORA_PORCE);
$PUNITORIO_PORCE =  !isset($dato) ? "0" : ($dato->PUNITORIO_PORCE == "" ?  "0" :   $dato->PUNITORIO_PORCE);
?>

<?php if (isset($dato)) : ?>
  <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
<?php endif; ?>

<div class="container-fluid col-12 col-md-6">

<div class="row">

  <div class="col-12 col-md-6">

    <div style="display: flex; flex-direction: column;">
      <label>CÓDIGO PRODUCTO:</label>
      <input name="CODIGO_PRODUCTO" maxlength="5" required type="text" class="form-control" value="<?= $CODIGO_PRODUCTO ?>">
    </div>
    <div style="display: flex; flex-direction: column;">
      <label>DESCRIPCIÓN:</label>
      <input name="DESCRIPCION" maxlength="30" required type="text" class="form-control" value="<?= $DESCRIPCION ?>">
    </div>


    <div style="display: flex; flex-direction: column;">
      <label>% INTERÉS:</label>
      <input name="INTERES_PORCE" type="text" class="form-control decimal" value="<?= $INTERES_PORCE ?>">
    </div>
    
    <div style="display: flex; flex-direction: column;">
      <label>DIAS SIN INTERÉS TRAS VENC.:</label>
      <input name="DIAS_SIN_INTERES" type="text" class="form-control entero" value="<?= $DIAS_SIN_INTERES ?>">
    </div>

    <div style="display: flex; flex-direction: column;">
      <label>% GASTOS ADM.:</label>
      <input name="GAST_ADM_PORCE" type="text" class="form-control decimal" value="<?= $GAST_ADM_PORCE ?>">
    </div>
    <div style="display: flex; flex-direction: column;">
      <label>SEGURO DE CANCELACIÓN:</label>
      <input name="SEGURO_CANCEL" type="text" class="form-control entero" value="<?= $SEGURO_CANCEL ?>">
    </div>

  </div>

  <div class="col-12 col-md-6">

  <div style="display: flex; flex-direction: column;">
      <label>% MORA:</label>
      <input name="MORA_PORCE" type="text" class="form-control decimal" value="<?= $MORA_PORCE ?>">
    </div>
    
 
    <div style="display: flex; flex-direction: row;">
      <div style="display: flex; flex-direction: column;">
        <label>DIAS P/MES:</label>
        <input maxlength="2" name="DIASXMES" type="text" class="form-control entero" value="<?= $DIASXMES ?>">
      </div>
      <div style="display: flex; flex-direction: column;">
        <label>DIAS P/AÑO:</label>
        <input maxlength="3" name="DIASXANIO" type="text" class="form-control entero" value="<?= $DIASXANIO ?>">
      </div>
    </div>




    <div style="display: flex; flex-direction: column;">
      <label>MESES P/AÑO:</label>
      <input maxlength="2" name="MESESXANIO" type="text" class="form-control entero" value="<?= $MESESXANIO ?>">
    </div>
    <div style="display: flex; flex-direction: column;">
      <label>SEGURO A NOM. DE 3ROS.:</label>
      <input name="SEGURO_3ROS" type="text" class="form-control entero" value="<?= $SEGURO_3ROS ?>">
    </div>
    <div style="display: flex; flex-direction: column;">
      <label>% PUNITORIO:</label>
      <input name="PUNITORIO_PORCE" type="text" class="form-control decimal" value="<?= $PUNITORIO_PORCE ?>">
    </div>

    <?php if (!isset($vista)) : ?>
    
      <button type="submit" class="btn btn-primary  w-100">GUARDAR</button>
     
  <?php endif; ?>
  </div>


</div>
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
      window.location= "<?=base_url("producto-finan/index")?>";
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