<?= $this->extend("layouts/index")?>

<?= $this->section("contenido") ?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert"  >
    <i class="material-icons">x</i>
  </button>
  <span>
    <b> <?= $titulo ?> </b> <?= $mensaje ?> </span>
</div>

<?= $this->endSection() ?>