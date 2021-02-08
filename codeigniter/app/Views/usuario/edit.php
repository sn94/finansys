<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a class="btn btn-sm btn-primary" href="<?= base_url("usuario/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE USUARIOS</a>


<div class="container p-2">
<h2 class="text-center prestyle">USUARIOS - ACTUALIZAR DATOS<small></small></h2>
<div class="clearfix"></div>
</div>

<!-- INI FORM -->
 
<?php
echo form_open("usuario/edit", 
['id'=> "edit-usuario-form", "style"=>"padding-left: 10px;",
 "class"=> "form-horizontal form-label-left container prestyle" ])
?>

<?php echo view('usuario/form'); ?>

</form>

<?= $this->endSection() ?>


