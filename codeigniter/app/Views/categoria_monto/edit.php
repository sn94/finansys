
<!-- INI FORM -->
<form style="padding-left: 10px;"    onsubmit='guardar(event)' class="form-inline prestyle" method="post" action="<?=base_url("categoria_monto/edit")?>">
 <input type="hidden" name="IDNRO" value="<?= $dato->IDNRO ?>">
<?php echo view('categoria_monto/form'); ?>

</form> 