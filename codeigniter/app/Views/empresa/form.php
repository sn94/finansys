<div class="row">

  <div class="col-12 col-md-3">
    <div class="form-group"  style="display: grid; grid-template-columns: 40% 60%;">
      <label style="grid-column-start: 1;">NOMBRE:</label>
      <input style="grid-column-start: 2;" maxlength="30" name="DESCR" type="text" class="form-control" value="<?= !isset($dato) ? "" :   $dato->DESCR ?>">

    </div>
  </div>

  <div class="col-12 col-md-2">
    <div class="form-group" style="display: grid; grid-template-columns: 50% 50%;">
      <label style="grid-column-start: 1;">LETRAS:</label>
      <input style="grid-column-start: 2;" size="3" name="LETRAS" type="text" class="form-control" value="<?= !isset($dato) ? "" :   $dato->LETRAS ?>">

    </div>


  </div>
  <?php if (!isset($vista)) : ?>
    <div class="col-12 col-md-2"   >
      <button   type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
  <?php endif; ?>




</div>