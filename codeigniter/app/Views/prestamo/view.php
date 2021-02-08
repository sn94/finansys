<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"  href="<?= base_url("prestamo/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE CRÉDITOS</a>


<div class="container p-2">
<h2 class="text-center prestyle">DETALLES DE PRÉSTAMO<small></small></h2>
<div class="clearfix"></div>
</div>

<?php echo view('prestamo/best_view', array("montos"=> $montos)  ); ?>
 
 
<script>
    
    window.onload= function(){
        habilitarCampos( "form-1" , false);
        habilitarCampos( "form-2" , false);
        habilitarCampos( "form-3" , false);
    }
</script>
<?= $this->endSection() ?>


