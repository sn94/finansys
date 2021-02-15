<?php

use App\Helpers\Utilidades;

?>

<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-OPERACIONES-PARA-VENC" value="<?= base_url('operacion/list') ?>">





<input type="text" oninput="filtrar_operaciones(event)" id="BUSCADO" placeholder="BUSCAR CLIENTE POR CEDULA, O NOMBRE" class="form-control">

<div id="GRILL">
</div>




<script>

  function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#GRILL").html(loader);
  }

  function hide_loader() {
    $("#GRILL").html("");
  }


  async function filtrar_operaciones(ev) {

    let buscado = ev == undefined ? "" : ev.target.value;
    let url_ = $("#INDEX-OPERACIONES-PARA-VENC").val();
    let payload=  buscado == "" ?  "ESTADO=APROBADO" :  ( "BUSCADO=" + buscado + "&ESTADO=APROBADO" );
    show_loader();

    let req = await fetch(url_, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: "BUSCADO=" + buscado
    });
    let html_result = await req.text();
    hide_loader();
    $("#GRILL").html(html_result);

  }


  window.onload = function() {
    filtrar_operaciones();
  };
</script>
<?= $this->endSection() ?>