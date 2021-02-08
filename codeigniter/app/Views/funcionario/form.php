<div class="row">

  <div class="col-12 col-md-6">
  <div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">CEDULA:</label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="8" oninput="input_number(event)" name="CEDULA" type="text" class="form-control"  value="<?= !isset($dato) ? "" :   $dato->CEDULA?>" >
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">NOMBRES: </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="50" name="NOMBRES" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->NOMBRES?>"  >
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">APELLIDOS:</label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="50" name="APELLIDOS" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->APELLIDOS?>"  >
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">DOMICILIO: </span>
  </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
  <input maxlength="60" name="DOMICILIO" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->DOMICILIO?>"   >
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">TELÉFONO </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="16" name="TELEFONO" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->TELEFONO?>" >
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">CELULAR</label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="16"  name="CELULAR" type="text" class="form-control"   value="<?= !isset($dato) ? "" :  $dato->CELULAR?>">
  </div>
</div>

  </div>





  <div class="col-12 col-md-6">
  <div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">CIUDAD:</label>
  <div class="col-md-9 col-sm-9 col-xs-12">

  <input type="text" maxlength="50" name="CIUDAD" id="CIUDAD" class="form-control col-md-10 ciudad" autocomplete="off">
 
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">CARGO:</label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <?= form_dropdown( "CARGO", $cargos, (!isset($dato) ? "" :  $dato->CARGO),['class'=> "select2_single form-control" ] ) ?>
    
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">HORARIO: </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="40" name="HORARIO" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->HORARIO?>">
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">DIAS LABORALES: </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <input maxlength="50" name="DIAS_LABO" type="text" class="form-control"  value="<?= !isset($dato) ? "" :  $dato->DIAS_LABO?>" >
  </div>
</div>

<div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">FOTO: </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input  onchange="show_loaded_image(event)"  name="FOTO" type="file" class="form-control"  >
        </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 "  id="FOTO">
    <img   style="width: 100%;height:100%;" src="<?= !isset($dato) ? "" : base_url( $dato->FOTO)?>" alt="">
  </div>

<?php if( !isset($vista)  ): ?>
  <div class="form-group mt-3">
  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
    <button type="submit" class="btn btn-success">GUARDAR</button>
  </div>
</div> 
<?php  endif;?>

</div>

</div>

<script>

window.onload= function(){
autocompletado();
  };
</script>
