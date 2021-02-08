 
<!-- INI FORM -->
 
<?php 
echo form_open_multipart("categoria_monto/create", 
[  "style"=>"padding-left: 20px;",
 "class"=> "form-inline prestyle" ])
?>



<?php echo view('categoria_monto/form'); ?>

</form> 