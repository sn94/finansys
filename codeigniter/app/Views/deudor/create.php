<?= $this->extend("layouts/index") ?>


<?= $this->section("title") ?>
FICHA DE CLIENTE 
<?= $this->endSection() ?>
 


<?= $this->section("contenido") ?>


<a class="btn btn-primary mb-3" style="font-weight: 600;" href="<?= base_url("deudor/index/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; Ir a Lista de clientes</a>

<!-- INI FORM --> 
<?php echo view('deudor/forms/form'); ?>
<?= $this->endSection() ?>


