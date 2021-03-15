<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>
<?=view("cobro/index/title_procesados")?>
 

<?= $this->endSection() ?>

<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-URL" value="<?= base_url('operacion/procesadas') ?>">

<div class="card">
   
 


  <div class="card-body">



    <input type="text" oninput="filtrar_operaciones(event)" id="BUSCADO" placeholder="BUSCAR CLIENTE POR CEDULA, O NOMBRE" class="form-control">

    <div class="table-responsive mt-1" id="GRILL">


      <?= view("cobro/index/grill_procesados") ?>

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
    if(!  confirm("Seguro que quiere borrar este registro?")) return;
    let pagina = ev.currentTarget.href;
    show_loader();
    let req = await fetch(pagina);
    let resp = await req.json();
    if ("ok" in resp) act_grilla();
    else alert(resp.err);
  }


  async function filtrar_operaciones(ev) {

    let buscado = ev == undefined ? "" : ev.target.value;
    let url_ = $("#INDEX-URL").val();
    show_loader();

    let req = await fetch(url_, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: "BUSCADO=" + buscado + "&LIMITE=10"
    });
    let resp = await req.text();
    $("#GRILL").html(   resp );
    
  }

  async function act_grilla(ev) {

    if (ev != undefined) ev.preventDefault();

    let pagina = ev == undefined ? $("#INDEX-URL").val() : ev.currentTarget.href;
    show_loader();
    let req = await fetch(pagina, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    let resp = await req.text();
    $("#GRILL").html(resp);
  }






  window.onload = function() {



  };
</script>
<?= $this->endSection() ?>