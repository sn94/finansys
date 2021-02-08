<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>
 

<?php  echo view("deudor/sumas_saldos_ajax"); ?>

<?= $this->endSection() ?>