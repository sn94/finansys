
<!-- INI FORM -->
<form onsubmit= "guardar(event)" style="padding-left: 10px;"  class="form-horizontal form-label-left container prestyle" method="post" action="<?=base_url("porcentaje/edit")?>">
 <input type="hidden" name="IDNRO" value="<?= $dato->IDNRO ?>">
<?php echo view('porcentaje/form'); ?>

</form> 