<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>



<input type="hidden" id="INDEX-URL" value="<?= base_url("porcentaje/index") ?>">

<div class="card">
  <div class="card-header card-header-primary">
    <h2 class="text-center prestyle">PORCENTAJES<small></small></h2>

  </div>

  <div class="card-body">



    <!--form -->
    <div id="formView">
      <?php echo view("porcentaje/create"); ?>
    </div>
    <!--End form-->

    <div id="GRILL" class="table-responsive">


    </div>
  </div>
</div>


<script>
  function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#GRILL").html(loader);
  }

  function hide_loader() {
    $("#GRILL").html("");
  }

  async function act_grilla(  ev ) {

    if(  ev != undefined)  ev.preventDefault();

    let pagina=  ev == undefined  ?  $("#INDEX-URL").val() : ev.currentTarget.href;
    show_loader();
    let req = await fetch(  pagina , {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    let resp = await req.text();
    $("#GRILL").html(resp);
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


  window.onload = function() {
    act_grilla();
  }
</script>
<?= $this->endSection() ?>