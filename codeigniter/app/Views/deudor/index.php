<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>



<div class="card">
  <div class="card-header card-header-primary">
    <h2 class="text-center prestyle"> CLIENTES<small></small></h2>
  </div>




  <div class="card-body">
    <a href="<?= base_url("deudor/create") ?>" class="btn btn-sm btn-primary">NUEVO</a>
    <a onclick="callToXlsGen(event, 'CLIENTES')" href="<?= base_url("deudor/index/json") ?>"><img src="<?= base_url("assets/img/excel_icon.png") ?>" alt="">XLS</a>
    <a href="<?= base_url("deudor/index/pdf") ?>"><img src="<?= base_url("assets/img/pdf_icon.png") ?>" alt="">PDF</a>



   <?= view("deudor/buscador")?>


  </div><!-- END CARD BODY  -->
</div>


<script>
  function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#GRILL").html(loader);
  }


  


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