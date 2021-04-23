<?php

use App\Models\Empresa_model;
use App\Models\Productos_finan_model;

$productos_financieros = (new Productos_finan_model())->get()->getResult();

$IDNRO =  isset($OPERACION) ?  $OPERACION->IDNRO :   "";
$CREDITO =  isset($CLIENTE) ?  $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ?  $OPERACION->CREDITO : "");
$PRIMER_VENCIMIENTO =    (isset($OPERACION) ?  ($OPERACION->PRIMER_VENCIMIENTO == "" ? date("Y-m-d")  :  $OPERACION->PRIMER_VENCIMIENTO) : date("Y-m-d"));
$NRO_CUOTAS =    (isset($OPERACION) ?  $OPERACION->NRO_CUOTAS : "0");
$PRODUCTO_FINA = isset($OPERACION) ?  $OPERACION->PRODUCTO_FINA : "";
$SISTEMA = isset($OPERACION) ?  $OPERACION->SISTEMA : "";


$FUNCIONARIO = session("ID");
?>


<?php if ($IDNRO !=  "") : ?>
    <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">
<?php endif; ?>


<input type="hidden" name="FUNCIONARIO" value="<?= $FUNCIONARIO ?>">




<div class="row">


    <div class="col-12 col-md-6">
        <?php if (isset($OPERACION)) : ?>

            <div class="form-group mb-1">
                <label>N° OPERACIÓN </label>
                <input readonly type="text" class="form-control" value="<?= $IDNRO ?>">
            </div>
        <?php endif; ?>



        <div class="form-group mb-1">
            <label>CRÉDITO: </label>
            <input value="<?= $CREDITO ?>" id="CREDITO" name="CREDITO" type="text" class="form-control entero">
        </div>
        <div class="form-group mb-1">
            <label>CUOTAS: </label>
            <input onfocus="if(this.value=='0') this.value='';" onblur="if(this.value=='') this.value= '0';  " value="<?= $NRO_CUOTAS ?>" id="NRO_CUOTAS" name="NRO_CUOTAS" type="text" class="form-control entero">
        </div>

        <div class="form-group mb-1">
            <label>1er VENCIMIENTO: </label>
            <input onchange="mostrarCuotas()" value="<?= $PRIMER_VENCIMIENTO ?>" id="PRIMER_VENCIMIENTO" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
        </div>


    </div>
    <div class="col-12 col-md-6">

        <!--PRODUCTO FINANCIERO-->

        <div class="form-group mb-1">
            <label>PRODUCTO FINANCIERO: </label>
            <select onchange="(async function(){ await obtener_data_producto_financiero();iniciar_calculos_de_operacion();})()" name="PRODUCTO_FINA" id="PRODUCTO_FINA" class="form-control">
                <?php foreach ($productos_financieros  as $prod) : ?>
                    <option <?= $PRODUCTO_FINA == $prod->IDNRO ? "selected" : "" ?> value="<?= $prod->IDNRO ?>"> <?= $prod->DESCRIPCION ?> </option>
                <?php endforeach; ?>
            </select>
        </div>


        <!--  Sistema de calculo -->
        <div class="form-group mb-1">
            <label>SISTEMA: </label>
            <select onchange="cambiarSistema(this.value)" name="SISTEMA" id="SISTEMA" class="form-control">

                <?php $sistemas =  ['FRANCES' => 'FRANCÉS', 'ALEMAN' => 'ALEMAN']; ?>
                <?php foreach ($sistemas  as $key => $value) : ?>
                    <option <?= $SISTEMA == $key ? "selected" : "" ?> value="<?= $key ?>"> <?= $value ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>


<script>
    function cambiarSistema() {


        iniciar_calculos_de_operacion();

    }
</script>