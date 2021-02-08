<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"  href="<?= base_url("garante/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE GARANTES</a>


<div class="container p-2">
<h2 class="text-center prestyle">FICHA DE GARANTES<small></small></h2>
<div class="clearfix"></div>
</div>

<!-- INI FORM -->
<form style="padding-left: 10px;"  id="viewgarante" enctype="multipart/form-data" class="form-horizontal form-label-left container prestyle" method="post" action="/garante/edit">
  
<?php echo view('garante/form'); ?>

</form>
<script>
    
    window.onload= function(){
        
        habilitarCampos( "viewgarante" , false);
    }
</script>
<?= $this->endSection() ?>


