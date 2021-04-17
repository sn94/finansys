<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
PRODUCTOS FINANCIEROS
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<?php 

$FORM_URL=  isset( $dato ) ? "producto-finan/edit" :  "producto-finan/create"; 
?>

<div id="loaderplace">
</div>

 
 <?php
    echo form_open(
        $FORM_URL,
        [
            "id"=> "param-form",
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container",
            "method"=> "POST",
            "onsubmit" => "guardar(event)"
        ]
    );
    ?>

 <?php echo view('producto_finan/form'); ?>

 </form>


<script>

function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#loaderplace").html(loader);
  }

  function hide_loader() {
    $("#loaderplace").html("");
  }

</script>
 

 <?= $this->endSection() ?>