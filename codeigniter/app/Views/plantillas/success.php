<?= $this->extend("layouts/main") ?>
<?= $this->section("contenido") ?>

<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> <?= $titulo ?> </b> <?= $mensaje ?> </span>
</div>

 
<?= $this->endSection() ?>