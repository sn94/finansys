
<!-- INI FORM -->
<form style="padding-left: 10px;"  class="form-horizontal form-label-left container prestyle" method="post" action="/empresa/edit">
 <input type="hidden" name="IDNRO" value="<?= $dato->IDNRO ?>">
<?php echo view('empresa/form'); ?>

</form> 