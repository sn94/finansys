<?php

/**Datos de cliente y su ultima solicitud */

$IDCLIENTE =  isset($CLIENTE) ?  $CLIENTE->IDNRO : (isset($OPERACION) ? $OPERACION->NRO_CLIENTE :   "");
$CEDULA =  isset($CLIENTE) ?  $CLIENTE->CEDULA : (isset($OPERACION) ? $OPERACION->CEDULA :   "");
$NOMBRES =  isset($CLIENTE) ?  ($CLIENTE->NOMBRES . " " . $CLIENTE->APELLIDOS) :  "";
$MONTO_SOLICITADO =   isset($CLIENTE) ? $CLIENTE->MONTO_SOLICI : (isset($OPERACION) ? $OPERACION->MONTO_SOLICI : "0");
$TIPO_CREDITO =  isset($CLIENTE) ?  $CLIENTE->TIPO_CREDITO : (isset($OPERACION) ?  $OPERACION->TIPO_CREDITO : "");

?>




<style>

#FICHA-CLIENTE div{
    margin: 0px;
}
</style>



<input name="NRO_CLIENTE" type="hidden"  value="<?= $IDCLIENTE ?>">


<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">NRO. CLIENTE: </label>
    <input readonly style="grid-column-start: 2;"   type="text" class="form-control" value="<?= $IDCLIENTE ?>">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">CÉDULA: </label>
    <input readonly style="grid-column-start: 2;" id="CEDULA" type="text" class="form-control" value="<?= $CEDULA ?>">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">NOMBRES: </label>
    <input readonly style="grid-column-start: 2;" type="text" class="form-control" value="<?= $NOMBRES ?>">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">MONTO SOLICITADO: </label>
    <input readonly style="grid-column-start: 2;" type="text" class="form-control entero" value="<?= $MONTO_SOLICITADO ?>">
</div>