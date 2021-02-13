<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>



<div class="card">
  <div class="card-header card-header-primary">
    <h2 class="text-center prestyle"> GESTIÓN OPERACIONES<small></small></h2>
  </div>



  <div class="card-body">
    <a href="<?= base_url("operacion/elegir-cliente") ?>" class="btn btn-sm btn-primary">CREAR OPERACIÓN</a>
    <a onclick="callToXlsGen(event, 'CLIENTES')" href="<?= base_url("deudor/index/json") ?>"><img src="<?= base_url("assets/img/excel_icon.png") ?>" alt="">XLS</a>
    <a href="<?= base_url("deudor/index/pdf") ?>"><img src="<?= base_url("assets/img/pdf_icon.png") ?>" alt="">PDF</a>


    <!-- TABLA DE OPERACIONES APROBADAS  -->
    <h5 class="text-center">OPERACIONES APROBADAS</h5>
    <div class="table-responsive">

      <?= $this->include("operacion/grill") ?>

    </div>

  </div><!-- END CARD BODY  -->



</div>


<script>
  function borrarFila(ev) {

    ev.preventDefault();
    if (!confirm("BORRAR?")) return;
    $.ajax({
      url: ev.currentTarget.href,
      dataType: "json",
      success: function(resp) {
        console.log(typeof resp, resp);
        if (!("error" in resp)) //Ojo los parentesis internos
          $("#" + resp.id).remove();
      }
    });

  }
</script>
<?= $this->endSection() ?>