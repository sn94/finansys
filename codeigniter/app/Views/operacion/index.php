<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }
</style>

<input type="hidden" id="INDEX-CLIENTE" value="<?= base_url('deudor/index/json') ?>">
<input type="hidden" id="OPERACION-CREATE" value="<?= base_url('operacion/create') ?>">
<input type="hidden" id="OPERACION-LIST" value="<?= base_url('operacion/list') ?>">

<div class="card">
  <div class="card-header card-header-primary">
    <h2 class="text-center prestyle"> GESTIÓN DE OPERACIONES <small></small></h2>
  </div>



  <div class="card-body">

    <input type="text" oninput="filtrar_clientes(event)" id="BUSCADO" placeholder="BUSCAR CLIENTE POR CEDULA, O NOMBRE" class="form-control">

    <div class="table-responsive">


      <table class="table table-bordered table-striped table-hover">

        <thead>
          <tr style="font-family: mainfont;">
            <th>ACCIÓN</th>
            <th></th>
            <th>CEDULA</th>
            <th>NOMBRES,APELLIDOS</th>
            <th>TIPO CRÉDITO</th>
          </tr>
        </thead>

        <tbody id="TABLE-BODY">

        </tbody>
      </table>

    </div>

  </div><!-- END CARD BODY  -->



</div>


<script>
  var clientes_solicitudes = [];


  
  function show_loader() {
        let loader = "<img style='z-index: 400000;position: absolute;top: 30%;left: 50%;'  src='<?= base_url("assets/img/spinner.gif") ?>'   />";
        $("#TABLE-BODY").html(loader);
    }

    function hide_loader() {
        $("#TABLE-BODY").html("");
    }



  function cargar_tabla() {

  //  $("#TABLE-BODY").html("");
    show_loader();

    let create_row = function(row) {

      let create_cell = function(cell) {
        return "<td style='padding: 0px;' >" + cell + " </td> ";
      };

      let idnro = row.IDNRO;
      let cedula = row.CEDULA;
      let nombres = row.NOMBRES;
      let tipo_credito = row.TIPO_CREDITO;
      let link_ope_create = $("#OPERACION-CREATE").val() + "/" + idnro;
      let link_ope_list= $("#OPERACION-LIST").val() + "/" + idnro;
      
      /**campos */

      let boton_crear = " <a class='btn btn-primary btn-sm'  href='" + link_ope_create + "' >CREAR</a>";
      let boton_ver = " <a class='btn btn-primary btn-sm'  href='" + link_ope_list + "' >VER OP.</a>";

      let cell1 = create_cell(boton_crear);
      let cell11= create_cell(boton_ver);
      let cell2 = create_cell(cedula);
      let cell3 = create_cell(nombres);
      let cell4 = create_cell(tipo_credito);
      let string_r = "<tr> " + cell1 + cell11+ cell2 + cell3 + cell4 + " </tr>";
      return string_r;
    };
    $("#TABLE-BODY").html("");
    clientes_solicitudes.forEach(function(fila) {

      let row = create_row(fila);
      $("#TABLE-BODY").append(row);

    });

  }


  async function filtrar_clientes(ev) {

    let buscado = ev == undefined ? "" : ev.target.value;
    let url_ = $("#INDEX-CLIENTE").val();
    show_loader();

    let req = await fetch(url_, {
      "method": "POST",
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: "BUSCADO=" + buscado + "&LIMITE=10"
    });
    clientes_solicitudes = await req.json();
    hide_loader();
    cargar_tabla();
  }



  window.onload = function() {

    filtrar_clientes();
  };
</script>
<?= $this->endSection() ?>