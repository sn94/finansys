<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
REGISTRO DE OPERACIÓN
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>


 
<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/pendientes") ?>">

<div id="loaderplace">
</div>

<?php


$formAction=  isset( $EDITAR) ? "operacion/edit"  : "operacion/create";

echo form_open(   $formAction ,  ["onsubmit" => "guardarOperacion(event)"]);
?>
<?= view("operacion/forms/index") ?>
</form>

<script>
 






    window.onload = function() {

        inicializarAreaOperacion(); 
    }
</script>

<?= $this->endSection() ?>