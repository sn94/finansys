<?php

/**Datos de cliente y su ultima solicitud */

$IDCLIENTE =   (isset($OPERACION) ? $OPERACION->NRO_CLIENTE :   "");
$CEDULA =   isset($OPERACION) ? $OPERACION->CEDULA :   "";
$NOMBRES =  isset($OPERACION) ? $OPERACION->NOMBRES : "" ;
$MONTO_SOLICITADO =  isset($OPERACION) ? $OPERACION->MONTO_SOLICI : "0" ;
$TIPO_CREDITO =   isset($OPERACION) ?  $OPERACION->TIPO_CREDITO : "";

?>




<style>

#FICHA-CLIENTE div{
    margin: 0px;
}
</style>



<input name="NRO_CLIENTE" type="hidden"  value="<?= $IDCLIENTE ?>">
 
<div class="row">
<div class="col mb-1" >
    <label >NRO. CLIENTE: </label>
    <input readonly    type="text" class="form-control" value="<?= $IDCLIENTE ?>">
</div>
<div class="col mb-1" >
    <label >CÉDULA: </label>
    <input readonly  id="CEDULA" type="text" class="form-control" value="<?= $CEDULA ?>">
</div>
</div>
<div class="form-group mb-1" >
    <label >NOMBRES: </label>
    <input readonly  type="text" class="form-control" value="<?= $NOMBRES ?>">
</div>
<div class="form-group mb-1" >
    <label >MONTO SOLICITADO: </label>
    <input readonly  type="text" class="form-control entero" value="<?= $MONTO_SOLICITADO ?>">
</div> 