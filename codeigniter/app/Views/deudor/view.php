<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
<h2 class="text-center">FICHA DE DEUDOR<small></small></h2>
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"  href="<?= base_url("deudor/index/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE DEUDORES</a>

 

<!-- INI FORM -->
<form style="padding-left: 10px;"  id="viewdeudor" enctype="multipart/form-data" class="form-horizontal form-label-left container prestyle" method="post" action="/deudor/edit">

<?php echo view('deudor/forms/form', ['deudor_dato'=> $deudor_dato]); ?>

</form>
<script>
    
    window.onload= function(){
        habilitarCampos( "viewdeudor" , false);
    }
</script>
<?= $this->endSection() ?>


