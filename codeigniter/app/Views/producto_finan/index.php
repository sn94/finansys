<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
PRODUCTOS FINANCIEROS
<?= $this->endSection() ?>


<?= $this->section("contenido") ?>



<input type="hidden" id="INDEX-URL" value="<?= base_url("producto-finan/index") ?>">

<div id="loaderplace">
</div>
<a class="btn btn-primary btn-sm" href="<?= base_url('producto-finan/create') ?>">NUEVO</a>
<div class="container-fluid" id="grill">
  <?= view("producto_finan/grill") ?>

</div>

<script>
  function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#loaderplace").html(loader);
  }

  function hide_loader() {
    $("#loaderplace").html("");
  }



  function editarFila(ev) {
    ev.preventDefault();
    $.ajax({
      url: ev.currentTarget.href,
      success: function(resp) {
        $("#formView").html(resp);
      }
    });
  }


 async function borrarFila(ev) {

    ev.preventDefault();
    if (!confirm("BORRAR?")) return;

    let req=  await fetch(  ev.currentTarget.href );
    let resp =  await req.json(); 
        if (!("error" in resp)) //Ojo los parentesis internos
          $("#row" + resp.ok).remove();

     

  }
</script>
<?= $this->endSection() ?>