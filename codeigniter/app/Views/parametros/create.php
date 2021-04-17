<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div id="loaderplace">
</div>

<h4 class="text-center">PARÁMETROS</h4>
 <?php
    echo form_open(
        "parametros/create",
        [
            "id"=> "param-form",
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container",
            "method"=> "POST",
            "onsubmit" => "guardar(event)"
        ]
    );
    ?>

 <?php echo view('parametros/form'); ?>

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