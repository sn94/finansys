<?php

use App\Helpers\Utilidades;

?>

<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
VENCIMIENTOS
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-OPERACIONES-PARA-VENC" value="<?= base_url('operacion/list') ?>">





<input type="text" oninput="filtrar_operaciones(event)" id="BUSCADO" placeholder="BUSCAR POR CEDULA, O NOMBRE, O CÓDIGO DE OPERACION" class="form-control">


 

<a class="btn btn-primary mt-3" href="#">FACTURA CRÉDITO</a>
<a class="btn btn-primary mt-3" href="#">IMPRIMIR

</a>
<div id="GRILL" style="overflow-y: auto;height: 200px;"  >
</div>
<div id="GRILL-CUOTAS">
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
    if( "ok" in resp) act_grilla();
    else alert(  resp.err); 
  }


  async function filtrar_operaciones(ev) {

    let buscado = ev == undefined ? "" : ev.target.value;
    let url_ = $("#INDEX-OPERACIONES-PARA-VENC").val();
 //   let payload=  buscado == "" ?  "ESTADO=APROBADO" :  ( "BUSCADO=" + buscado + "&ESTADO=APROBADO" );
    show_loader();

    let req = await fetch(url_, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: "BUSCADO=" + buscado+"&ESTADO=PROCESADO"
    });
    let html_result = await req.text();
    hide_loader();
    $("#GRILL").html(html_result);

  }




  async function verCuotas(ev){
  ev.preventDefault();
    let url_ =ev.currentTarget.href; 
  
    let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
    $("#GRILL-CUOTAS").html(loader);


    let req = await fetch(url_, { 
      headers: { 
        'X-Requested-With': 'XMLHttpRequest'
      }  });
    let html_result = await req.text(); 
    $("#GRILL-CUOTAS").html(html_result);

  }


  window.onload = function() {
    filtrar_operaciones();
  };
</script>
<?= $this->endSection() ?>