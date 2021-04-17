<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
OPERACIONES PENDIENTES 
<?= $this->endSection() ?>



<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-URL" value="<?= base_url('operacion/pendientes') ?>">

<div class="card pt-0">
   
  <div class="card-body mt-0 pt-0">

    <a class="btn btn-primary" href="<?= base_url('operacion/create') ?>">CREAR OPERACIÓN</a>



    <div class="table-responsive" id="GRILL">


      <?= view("operacion/index/pendientes/grill") ?>

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

    if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        
        
    if( "ok" in resp) act_grilla();
    else alert(  resp.err); 
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