<?= $this->extend("layouts/index") ?>


<?= $this->section("title") ?>
<h2 class="prestyle">NUEVO CLIENTE<small></small></h2>
<?= $this->endSection() ?>
 


<?= $this->section("contenido") ?>


<a class="btn btn-danger mb-3" style="font-weight: 600;" href="<?= base_url("deudor/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; Ir a Lista de clientes</a>

<!-- INI FORM --> 
<?php echo view('deudor/forms/form'); ?>

 
 
 


<?= $this->endSection() ?>


