 
<!-- INI FORM -->
 
<?php 
echo form_open_multipart("empresa/create", 
[  "style"=>"padding-left: 5px;",
 "class"=> "form-horizontal form-label-left container prestyle" ]);
?>




<?php echo view('empresa/form'); ?>

</form> 