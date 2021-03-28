<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
COBROS
<?= $this->endSection() ?>



<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-URL" value="<?= base_url('cobro/index') ?>">

<div class="card pt-0">

  <div class="card-body mt-0 pt-0">

    <a class="btn btn-primary" href="<?= base_url('cobro/create') ?>">NUEVO COBRO</a>


    <!--Filtros de busqueda  -->

<div style="padding-top: 2px; display: flex; flex-direction: row;justify-content: space-around;flex-wrap: wrap;">
<label  style="width: 100%;" > <input style="width: 100%;" placeholder="BUSCAR POR CEDULA, NOMBRE, APELLIDO O CODIGO DE OPERACION" oninput="act_grilla()" type="text" id="BUSQUEDA-POR-PATRON-COBRO-FILTER"></label>

<label style="width: 100%;" >Filtrar por fecha: <input onchange="act_grilla()" type="date" id="FECHA-COBRO-FILTER"></label>

</div>
  

    <div class="table-responsive" id="GRILL">


      <?= view("cobro/index/grill/index") ?>

    </div>

  </div><!-- END CARD BODY  -->



</div>


<script>
  function show_loader() {
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#GRILL").html(loader);
  }

  function hide_loader() {
    $("#GRILL").html("");
  }





  async function borrar(ev) {
    ev.preventDefault();
    let pagina = ev.currentTarget.href;
    show_loader();
    let req = await fetch(pagina);
    let resp = await req.json();
    if ("ok" in resp) act_grilla();
    else alert(resp.err);
  }




  async function act_grilla(ev) {

    if (ev != undefined) ev.preventDefault();

    let pagina = ev == undefined ? $("#INDEX-URL").val() : ev.currentTarget.href;
    show_loader();

    //PARAMETROS
    //BUSCADO , FECHA, ETC
    let fecha = $("#FECHA-COBRO-FILTER").val();
    let terminoBuscado = $("#BUSQUEDA-POR-PATRON-COBRO-FILTER").val();

    let parametros = {
      FECHA: fecha,
      BUSCADO: terminoBuscado
    };

    let req = await fetch(pagina, {
      method: "POST",
      headers: {
        'Content-Type': "application/json",
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(parametros)
    });
    let resp = await req.text();
    $("#GRILL").html(resp);
  }






  window.onload = function() {



  };
</script>
<?= $this->endSection() ?>