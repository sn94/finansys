<?php


$CREDITO =  isset($CLIENTE) ?  $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ?  $OPERACION->CREDITO : "");
$PRIMER_VENCIMIENTO =    (isset($OPERACION) ?  $OPERACION->PRIMER_VENCIMIENTO : "");
$NRO_CUOTAS =    (isset($OPERACION) ?  $OPERACION->NRO_CUOTAS : "0");
?>


<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">CRÉDITO: </label>
    <input style="grid-column-start: 2;" value="<?= $CREDITO ?>" id="CREDITO" name="CREDITO" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">1er VENCIMIENTO: </label>
    <input style="grid-column-start: 2;" value="<?= $PRIMER_VENCIMIENTO ?>" name="PRIMER_VENCIMIENTO" type="date" class="form-control">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%;">
    <label style="grid-column-start: 1;">N° CUOTAS: </label>
    <input style="grid-column-start: 2;" value="<?= $NRO_CUOTAS ?>" id="NRO_CUOTAS" name="NRO_CUOTAS" type="text" class="form-control entero">
</div>