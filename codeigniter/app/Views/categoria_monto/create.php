 
<!-- INI FORM -->
 
<?php 
echo form_open_multipart("categoria_monto/create" ,   ['onsubmit'=> 'guardar(event)'])
?>



<?php echo view('categoria_monto/form'); ?>

</form> 