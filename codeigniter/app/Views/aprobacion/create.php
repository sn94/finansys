<?= $this->extend("layouts/index") ?>
<?= $this->section("title") ?>
APROBACIÓN DE OPERACIÓN Y GENERACIÓN DE VENCIMIENTOS
<?= $this->endSection() ?>




<?= $this->section("contenido") ?>

<style>
    input[readonly] {
        background-color: #8a96d7 !important;
        color: black !important;
    }

 
#loaderplace-textual { 
 
  position: absolute;
  top: 5%;
  margin-left: 25%;
}

#loaderplace-textual p {
  text-align: center;
  font-weight: 600;
  background-color: #03f1e6;
  padding: 20px;
  border: 2px solid #3f51b5;
 
}


</style>


<!-- LINK AL CUAL SE DEBE DIRECCIONAR AL TERMINAR DE GRABAR -->
<input type="hidden" id="OPERACIONES-INDEX" value="<?= base_url("operacion/aprobar") ?>">
<!--LISTA LA OPERACIONES DE CREDITO REGISTRADAS PARA OBTENER EL ULTIMO CODIGO Y GENERAR UNO NUEVO,
EL ULTIMO + 1 -->
<input type="hidden" id="INDEX-OPERACIONES" value="<?= base_url('operacion/list') ?>">

<div id="loaderplace">
</div>



<?php
echo form_open("operacion/aprobar",  ["onsubmit" => "guardarAprobacionOperacion(event)"]);
?>

<!--UNA VEZ APROBADO EL CREDITO CAMBIARA SU ESTADO -->
<input type="hidden" name="ESTADO" value="APROBADO">
<input type="hidden" name="PROCESADO_POR" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-1 pt-2">
    <!-- VIEW: Codigo de operacion, empresa encargada, numero de factura -->
    <?= view("operacion/forms/form_codigos") ?>
</div>


<div id="loaderplace-textual" class="d-none">
<p>Verificando tipo de producto...</p>
</div>
<div class="row mr-md-5 ml-md-5 mb-1 bg-primary text-light rounded">

    <div class="col-12 col-md-4 ">
        <!--DATOS DE CLIENTE (SOLO LECTURA )-->
        <?= view("operacion/forms/form_cliente_view") ?>
    </div>

    <div class="col-12 col-md-8">
        <!-- VIEW:  monto de credito , numero de cuotas y fecha de primer vencimiento -->
        <?= view("operacion/forms/form_data_principal") ?>

    </div>


</div>

<div class="row mr-md-5 ml-md-5 mb-1 text-light pt-2  bg-primary rounded">
    <div class="col-12 col-md-3 ">
        <!-- VIEW: Gastos administrativos, seguro de cancelacion, seguro de terceros -->
        <?= view("operacion/forms/form_seguro_gasto") ?>
    </div>

    <div class="col-12 col-md-5">
        <!-- VIEW: parametros de total en intereses, total IVA de intereses, porcentaje de interes y  porcentaje de IVA -->
        <?= view("operacion/forms/form_intereses") ?>
        <!-- VIEW: monto final del prestamo, capital neto a desembolsar, importe de la cuota      -->
        <?= view("operacion/forms/form_montos_calculados") ?>
    </div>

    <div class="col-12 col-md-4 ">
        <h5 class="text-center text-light">GARANTES</h5>
        <?= view("operacion/forms/form_garantes") ?>
    </div>
</div>

<?= view("aprobacion/create_detail_cuotas") ?>

<div class="row mr-md-5 ml-md-5 ">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"> GUARDAR</button>
    </div>
</div>
</form>





 

<?= view("operacion/js/boot") ?>

<script>
  






    window.onload = async function() {

        inicializarAreaOperacion(); 
        //Codigo de operacion
        generar_codigo_operacion();
 
    }
</script>

<?= $this->endSection() ?>