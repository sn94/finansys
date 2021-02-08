<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a class="btn btn-sm btn-primary" href="<?= base_url("usuario/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE USUARIOS</a>


<div class="container p-2">
<h2 class="text-center">FICHA DE USUARIO<small></small></h2>
<div class="clearfix"></div>
</div>

<!-- INI FORM -->
<form style="padding-left: 10px;"  id="viewusuario" enctype="multipart/form-data" class="form-horizontal form-label-left container" method="post" action="/usuario/edit">

<?php echo view('usuario/form'); ?>

</form>
<script>
    
    window.onload= function(){
        habilitarCampos( "viewusuario" , false);
    }
</script>
<?= $this->endSection() ?>


