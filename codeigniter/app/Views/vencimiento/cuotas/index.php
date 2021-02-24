
<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>



<a class="btn btn-primary mb-2" href="<?=base_url("operacion/generar-vencimiento")?>">VOLVER A VENCIMIENTOS</a>

<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


 <?=view("vencimiento/cuotas/grill")?>
<?= $this->endSection() ?>