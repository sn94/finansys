<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"href="<?= base_url("deudor/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; IR A LISTADO DE CLIENTES</a>


<div class="container p-2">
<h2 class="text-center prestyle">ACTUALIZAR DATOS DE CLIENTE<small></small></h2>
<div class="clearfix"></div>
</div>

<!-- INI FORM -->
 
<?php 
echo form_open_multipart("deudor/edit", 
['id'=> "edit-deudor-form", "style"=>"padding-left: 10px;",
 "class"=> "form-horizontal form-label-left container prestyle" ])
?>

<?php echo view('deudor/forms/form'); ?>


<?php if (isset($OPERACION) && $OPERACION != "V") : ?>

<div class="form-group mt-3">
  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
    <button type="submit" class="btn btn-primary">GUARDAR</button>
  </div>
</div>
<?php endif; ?>

</form>

<?= $this->endSection() ?>


