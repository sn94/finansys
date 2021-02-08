<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"  href="<?= base_url("prestamo/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE CRÉDITOS</a>


<div class="container p-2">
<h2 class="text-center prestyle">ACTUALIZACIÓN DE DATOS<small></small></h2>
<div class="clearfix"></div>
</div>

<!-- INI FORM -->
  
<?php echo view('prestamo/best_view'); ?>

 

<?= $this->endSection() ?>


