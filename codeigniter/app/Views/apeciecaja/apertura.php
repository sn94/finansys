 
  
 <?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>
 
<?php
echo view("apeciecaja/apertura_ajax");
?>


<?= $this->endSection() ?>