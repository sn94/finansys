<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
BUSQUE UN CLIENTE PARA CREAR UNA OPERACIÓN
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>

<style>
  #BUSCADO::placeholder {
    color: black;
  }

  #BUSCADOR-CLIENTES thead tr th:nth-child(0), #BUSCADOR-CLIENTES thead tr th:nth-child(1){
width: 90px;
  }
</style>

<input type="hidden" id="INDEX-CLIENTE" value="<?= base_url('deudor/index/json') ?>">
<input type="hidden" id="OPERACION-CREATE" value="<?= base_url('operacion/create') ?>">
<input type="hidden" id="OPERACION-LIST" value="<?= base_url('operacion/list') ?>">

<div class="card pt-0">
 

  <div class="card-body mt-0 pt-0">

    <input type="text" oninput="filtrar_clientes(event)" id="BUSCADO" placeholder="BUSCAR CLIENTE POR CEDULA, O NOMBRE" class="form-control">

    <div class="table-responsive">


      <table id="BUSCADOR-CLIENTES" class="table table-bordered table-striped table-hover table-info">

        <thead>
          <tr style="font-family: textfont;">
            <th>ACCIÓN</th>
            <th></th>
            <th>CEDULA</th>
            <th>NOMBRES,APELLIDOS</th>
            <th>DOMICILIO</th>
            <th>TELÉFONO</th>
            <th>REGISTRADO</th>
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
      let nombres = row.NOMBRE_COMPLETO;
      let domicilio = row.DOMICILIO;
      let telefono= row.TELEFONO;
      let registrado= row.REGISTRADO;

      let link_ope_create = $("#OPERACION-CREATE").val() + "/" + idnro;
      let link_ope_list= $("#OPERACION-LIST").val() + "/" + idnro;
      
      /**campos */

      let boton_crear = " <a class='btn btn-primary btn-sm w-100'  href='" + link_ope_create + "' >CREAR</a>";
      let boton_ver = " <a   href='" + link_ope_list + "' > <i class='fa fa-eye'  ></i> </a>";

      let cell1 = create_cell(boton_crear);
      let cell11= create_cell(boton_ver);
      let cell2 = create_cell(cedula);
      let cell3 = create_cell(nombres);
      let cell4 = create_cell(domicilio);
      let cell5 = create_cell(telefono);
      let cell6 = create_cell(registrado);
      let string_r = "<tr> " + cell1 + cell11+ cell2 + cell3 + cell4 + cell5+ cell6+" </tr>";
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
    if(  "auth_error" in clientes_solicitudes )
        {
            alert(  clientes_solicitudes.auth_error );
            window.location=  clientes_solicitudes.redirect;
        }
        

    hide_loader();
    cargar_tabla();
  }



  window.onload = function() {

    filtrar_clientes();
  };
</script>
<?= $this->endSection() ?>