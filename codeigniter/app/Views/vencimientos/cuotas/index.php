
<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>



<a class="btn btn-primary mb-2" href="<?=base_url("operacion/aprobar")?>">VOLVER A VENCIMIENTOS</a>

<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


 <?=view("operacion/index/aprobados/cuotas/grill")?>
<?= $this->endSection() ?>