<?php

/**Datos de cliente y su ultima solicitud */

$IDCLIENTE =   (isset($CLIENTE) ? $CLIENTE->IDNRO :   "");
$CEDULA =   isset($CLIENTE) ? $CLIENTE->CEDULA :   "";
$NOMBRES =  isset($CLIENTE) ? $CLIENTE->NOMBRES : "" ;
$MONTO_SOLICITADO =  isset($CLIENTE) ? $CLIENTE->MONTO_SOLICI : "0" ;
$FECHA_SOLICITADO =  isset($CLIENTE) ? $CLIENTE->FECHA_SOLICI : date("Y-m-d");
$TIPO_CREDITO =   isset($CLIENTE) ?  $CLIENTE->TIPO_CREDITO : "";

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
<div class="form-group mb-1 " >
    <label >MONTO SOLICITADO: </label>
    <input readonly  type="text" class="form-control entero" name="MONTO_SOLICI" value="<?= $MONTO_SOLICITADO ?>">
</div> 

<input type="hidden" name="FECHA_SOLICI"   value="<?= $FECHA_SOLICITADO ?>">