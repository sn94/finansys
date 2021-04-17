<?php

use App\Models\Productos_finan_model;

$productos_financieros = (new Productos_finan_model())->get()->getResult();

$IDNRO =  isset($OPERACION) ?  $OPERACION->IDNRO :   "";
$CREDITO =  isset($CLIENTE) ?  $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ?  $OPERACION->CREDITO : "");
$PRIMER_VENCIMIENTO =    (isset($OPERACION) ?  ($OPERACION->PRIMER_VENCIMIENTO == "" ? date("Y-m-d")  :  $OPERACION->PRIMER_VENCIMIENTO) : date("Y-m-d"));
$NRO_CUOTAS =    (isset($OPERACION) ?  $OPERACION->NRO_CUOTAS : "0");
$PRODUCTO_FINA = isset($OPERACION) ?  $OPERACION->PRODUCTO_FINA : "";
$SISTEMA = isset($OPERACION) ?  $OPERACION->SISTEMA : "";
?>


<?php if ($IDNRO !=  "") : ?>
    <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
<?php endif; ?>

<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">CRÉDITO: </label>
    <input style="grid-column-start: 2;" value="<?= $CREDITO ?>" id="CREDITO" name="CREDITO" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%;">
    <label style="grid-column-start: 1;">N° CUOTAS: </label>
    <input onfocus="if(this.value=='0') this.value='';" onblur="if(this.value=='') this.value= '0';  " style="grid-column-start: 2;" value="<?= $NRO_CUOTAS ?>" id="NRO_CUOTAS" name="NRO_CUOTAS" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
    <input onchange="mostrarCuotas()" style="grid-column-start: 2;" value="<?= $PRIMER_VENCIMIENTO ?>" id="PRIMER_VENCIMIENTO" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
</div>

<!--PRODUCTO FINANCIERO-->

<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">PRODUCTO FINANCIERO: </label>
    <select onchange="(async function(){ await obtener_data_producto_financiero();iniciar_calculos_de_operacion();})()" style="grid-column-start: 2;" name="PRODUCTO_FINA" id="PRODUCTO_FINA" class="form-control">
        <?php foreach ($productos_financieros  as $prod) : ?>
            <option <?= $PRODUCTO_FINA == $prod->IDNRO ? "selected" : "" ?> value="<?= $prod->IDNRO ?>"> <?= $prod->DESCRIPCION ?> </option>
        <?php endforeach; ?>
    </select>
</div>


<!--  Sistema de calculo -->
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">SISTEMA: </label>
    <select onchange="cambiarSistema(this.value)" style="grid-column-start: 2;" name="SISTEMA" id="SISTEMA" class="form-control">

        <?php $sistemas =  ['FRANCES' => 'FRANCÉS', 'ALEMAN' => 'ALEMAN']; ?>
        <?php foreach ($sistemas  as $key => $value) : ?>
            <option <?= $SISTEMA == $key ? "selected" : "" ?> value="<?= $key ?>"> <?= $value ?> </option>
        <?php endforeach; ?>
    </select>
</div>


<script>
    function cambiarSistema() {


        iniciar_calculos_de_operacion();

    }
</script>