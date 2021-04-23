<?php


$SEGURO_CANCEL =    (isset($OPERACION) ?  $OPERACION->SEGURO_CANCEL : "0");
$SEGURO_3ROS =    (isset($OPERACION) ?  $OPERACION->SEGURO_3ROS : "0");
$GASTOS_ADM =    (isset($OPERACION) ?  $OPERACION->GASTOS_ADM : "0");


?>

 
<div class="form-group mb-1">
    <label >SEGURO DE CANCELACIÓN: </label>
    <input readonly  value="<?= $SEGURO_CANCEL ?>" id="SEGURO_CANCEL" name="SEGURO_CANCEL" type="text" class="form-control entero" value="0">
</div>

<div class="form-group mb-1">
    <label >SEGURO DE 3ROS: </label>
    <input readonly  value="<?= $SEGURO_3ROS ?>" id="SEGURO_3ROS" name="SEGURO_3ROS" type="text" class="form-control entero" value="0">
</div>

<div class="form-group mb-1">
    <label >GASTOS ADM.: </label>
    <input readonly  value="<?= $GASTOS_ADM ?>" id="GASTOS_ADM" name="GASTOS_ADM" type="text" class="form-control entero" value="0">
</div> 