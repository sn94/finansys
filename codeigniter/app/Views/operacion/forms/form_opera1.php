<?php

$IDNRO =  isset($OPERACION) ?  $OPERACION->IDNRO :   "";

$CREDITO =  isset($CLIENTE) ?  $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ?  $OPERACION->CREDITO : "");
$PRIMER_VENCIMIENTO =    (isset($OPERACION) ?  $OPERACION->PRIMER_VENCIMIENTO : date("Y-m-d"));
$NRO_CUOTAS =    (isset($OPERACION) ?  $OPERACION->NRO_CUOTAS : "0");
?>


<?php if(  $IDNRO !=  ""): ?>
<input type="hidden" name="IDNRO"  value="<?= $IDNRO?>">
<?php   endif; ?>

<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">CRÉDITO: </label>
    <input style="grid-column-start: 2;" value="<?= $CREDITO ?>" id="CREDITO" name="CREDITO" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
    <input onchange="mostrarCuotas()" style="grid-column-start: 2;" value="<?= $PRIMER_VENCIMIENTO ?>" id="PRIMER_VENCIMIENTO" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%;">
    <label style="grid-column-start: 1;">N° CUOTAS: </label>
    <input style="grid-column-start: 2;" value="<?= $NRO_CUOTAS ?>" id="NRO_CUOTAS" name="NRO_CUOTAS" type="text" class="form-control entero">
</div>