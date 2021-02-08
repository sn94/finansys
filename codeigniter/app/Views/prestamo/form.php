<!--CAMPOS OCULTOS --> 

<input type="hidden" name="IDNRO" value="<?= !isset($prestamo_dato) ? "" : $prestamo_dato->IDNRO?>">
<input type="hidden" name="DEUDOR" value="<?= !isset($prestamo_dato) ? "" : $prestamo_dato->DEUDORID?>">
<input type="hidden" name="GARANTE" value="<?= !isset($prestamo_dato) ? "" : $prestamo_dato->GARANTEID?>">
<input type="hidden" name="FUNCIONARIO"  value="<?= session("ID")?>">

<div class="row"  >

<div class="col-xs-12 col-md-6">

  <div class="row">
  <div class="col-12 col-md-4">
  <div class="form-group">
  <label>CI°/RUC TITULAR:</label>
  <input id="CI_TITULAR"   readonly    type="text" class="form-control"  value="<?= !isset($prestamo_dato) ? "" :   $prestamo_dato->DEUDORCI?>" >
</div>
  </div>
  <div class="col-12 col-md-8">
      <div class="form-group">
      <label >NOMBRE COMPLETO: </label>
      <input id="TITULAR_NOMBRES" readonly type="text" class="form-control"  value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->DEUDORNOM?>"  >
    </div>
  </div>
  <div class="col-12 col-md-4">
  <div class="form-group">
  <label>CI° GARANTE:</label>
  <input id="CI_GARANTE"  readonly     type="text" class="form-control"  value="<?= !isset($prestamo_dato->GARANTECI) ? "" :   $prestamo_dato->GARANTECI?>" >
</div>
  </div>

  <div class="col-12 col-md-8">
      <div class="form-group">
      <label >NOMBRE COMPLETO: </label>
      <input id="GARANTE_NOMBRES" readonly type="text" class="form-control"  value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM?>"  >
    </div>
  </div>

  </div>
</div>
  

<div class="col-xs-12 col-md-6">
  <div class="row">
      <div class="col-xs-12 col-md-12">

      <div class="form-group">
      <label >CATEGORÍA MONTO:</label> 
        <?= form_dropdown( "CAT_MONTO", $montos, !isset($prestamo_dato) ? "" :  $prestamo_dato->CAT_MONTO,['class'=> "select2_single form-control" ] ) ?>   
      </div>
  </div>
  <div class="col-xs-12 col-md-12">
    <div class="form-group">
      <label >OBSERVACIÓN:</label>
      <textarea  <?= $OPERACION=="V" ? "readonly": ""?>  name="OBSERVACION" type="text" class="form-control"  value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->OBSERVACION?>"  >
      </textarea>
    </div>
  </div>


  </div><!-- END ROW -->
</div>

</div><!--END ROW --> 




<?php if( isset($OPERACION) && ($OPERACION=="V" || $OPERACION=="M")  ): ?>
    <div class="row">

      <div class="col-12 col-md-4">
        <div class="form-group">
          <label >FECHA SOLICITUD:</label>
          <input readonly   type="date" class="form-control"  value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->FECHA_SOLICI?>"  >
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="form-group">
          <label >FECHA ENTREGA:</label>
          <input    <?= $OPERACION=="V" ? "readonly": ($prestamo_dato->ESTADO != "P" ? "readonly" : "") ?>    type="date" class="form-control"  value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->FECHA_ENTREGA?>"  >
        </div>
      </div>

    </div><!-- END ROW -->

    <?php endif; ?>

    
    <div class="row">
       
        <?php if( isset($OPERACION)  && $OPERACION!="V" ): ?>
      <div class="col-xs-12 col-md-offset-8 col-md-4">
      <button type="submit" class="btn btn-success">GUARDAR</button>
        </div>
    <?php  endif;?>

    </div>






 
 
 
 


<script>

window.onload= function(){
autocompletado( "#CIUDAD");
  };


 





</script>
