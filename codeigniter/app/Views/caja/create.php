 
<!-- INI FORM -->
 
<?php 
echo form_open_multipart("caja/create", 
[  "style"=>"padding-left: 5px;",
 "class"=> "form-horizontal form-label-left container prestyle" ]);
?>


 


<?php echo view('caja/form'); ?>

</form> 