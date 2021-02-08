<div class="row">

  <div class="col-12 col-md-6">
  <div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">NOMBRE:</label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="15" name="NOMBRE" type="text" class="form-control"  value="<?= !isset($dato) ? "" :   $dato->NOMBRE?>" >
  </div>
</div>
</div>
<?php if( !isset($vista)  ): ?>
<div class="col-12 col-md-6">
<button type="submit" class="btn btn-primary">GUARDAR</button>
</div>
<?php  endif;?>

 


</div>

 