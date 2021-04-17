 
<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
<?php echo  view("cobro/proceso/title");  ?>
<?= $this->endSection() ?>


<?= $this->section("contenido") ?>


<?php echo  view("validations/form_validate");  ?>
<?php echo  view("validations/formato_numerico");  ?>



<style>
  tr {
    margin: 0px
  }

  td {
    padding-bottom: 0px !important;
    margin-bottom: 2px !important;
    font-weight: 600;
    color: #1d1d1d;
    font-size: 18px;
  }

  th {
    font-size: 18px;
  }
</style>



<div id="vista-form-cobro">
  <?php echo form_open("cobro/create", ['id' => "cobro-form", 'onsubmit' => 'guardarCobro(event)']); ?>

  <div class="container">
    <button type="submit" class="btn btn-danger">COBRAR</button>
  </div>

  <!--CAMPOS OCULTOS -->
  <?php echo  view("cobro/proceso/campos_ocultos");  ?>


  <div class="row">

    <div class="col-12 col-md-8">
      <?php echo  view("cobro/proceso/form_cuotas");  ?>
    </div>
    <div class="col-12 col-md-4">
      <?php echo  view("cobro/proceso/totales");  ?>
    </div>
  </div>

  </form>

</div>







<script>
  /**Validaciones antes de grabar */

  function numeroCuotasDefinido() {
    if ($("#CUOTAS_PAGADAS").val() == "" || $("#CUOTAS_PAGADAS").val() == "0") {
      alert("Indique por favor el número de cuotas");
      return false;
    }
    return true;
  }

  function numeroCuotasIngresadoValido() {


    let nroCuotasFromInput = formValidator.limpiarNumero($("#CUOTAS_PAGADAS").val());
    let nroCuotas = parseInt(nroCuotasFromInput);
    //numero de cuotas pendientes de pago
    let pendientes = cuotas_data_model
      .map((ar) => ar.ESTADO)
      .reduce((acum, valor) => acum + (valor == "P" ? 1 : 0), 0);

    if (nroCuotas > pendientes) {
      alert("El número de cuotas ingresado es mayor a las pendientes");
      return false;
    } else return true;
  }



  async function guardarCobro(ev) {

    ev.preventDefault();

    if (!(numeroCuotasDefinido() && numeroCuotasIngresadoValido())) return;

    formValidator.init(ev.target);
    let cabecera = formValidator.getData("application/json");

    let dataPayload = {
      CABECERA: cabecera,
      DETALLE: cuotas_data_model
    }
    let req = await fetch(ev.target.action, {
      method: "POST",
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dataPayload)
    });
    let resp = await req.json();

    if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        

        
    if ("ok" in resp) {
      alert("Cobro registrado");
      window.location = "<?= base_url("operacion/procesadas") ?>";
    } else alert(resp.err);
    //ev.target.submit( );

  }






  //FUNCION IMPRIMIR RECIBO 
  //RECIBE EL ID DE RECIBO
  //O INTERPRETA EL PARAMETRO COMO UNA URL A SOLICITAR
  async function printBill(ID_RECIBO) {

    if (typeof ID_RECIBO == "object")
      ID_RECIBO.preventDefault(); //prevenir evento 

    let urlBill = "";
    if (typeof ID_RECIBO == "object")
      urlBill = ID_RECIBO.currentTarget.href;
    else
      urlBill = "<?= base_url('prestamo/mostrarRecibo') ?>/" + ID_RECIBO;

    $.ajax({
      url: urlBill,
      success: function(html) {
        //print
        let documentTitle = "PAGOS";
        var ventana = window.open("", 'PRINT', 'height=400,width=600');
        ventana.document.write(html);
        ventana.document.close();
        ventana.focus();
        ventana.print();
        ventana.close();
      }
    });
  }




  window.onload = async function() {
    //PREPARAR AREA PARA EL CALCULO
    await obtener_parametros();
    await cargar_modelo_cuotas();
    await mostrar_cuotas();

    //Formato numerico
    formatoNumerico.formatearCamposNumericos();


    //Agregar nuevo evento Para calculo autom. de mora
    let oldEvent = document.getElementById("CUOTAS_PAGADAS").oninput;
    let newEvent = typeof oldEvent == "function" ? (function(ev) {
      oldEvent(ev);
      calcularTotalPagar(ev);
    }) : ((ev) => calcularTotalPagar(ev));

    document.getElementById("CUOTAS_PAGADAS").oninput = newEvent;

  };
</script>





<?= $this->endSection() ?>