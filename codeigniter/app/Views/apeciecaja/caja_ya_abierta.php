<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div class="card">
<div class="card-header card-header-primary">
<h4 class="prestyle" style="color: #130257; font-weight: bold;" class="card-title "></h4>
                  
</div>

<div class="card-body">
  
<h3><?=$MENSAJE?></h3>
<a href="<?=base_url("apeciecaja/arqueo_cierre")?>">CERRAR CAJA</a>   

</div>
</div>
<?= $this->endSection() ?>