<?php

use App\Helpers\Utilidades; 

?>




<?php
//CAMPOS OCULTOS
//datos
$ID_OPERACION =  $prestamo_dato->IDNRO;
$FECHA =  date("Y-m-j");
$CAJERO = session("ID");
$DEUDOR_ID =  $prestamo_dato->NRO_CLIENTE;
$CAJA = session("CAJA");
$CREDITO =  Utilidades::number_f($prestamo_dato->CREDITO);
?>


<!-- *********************CABECERA COBRO *****************-->
<!-- ID DE PRESTAMO -->
<input type="hidden" name="IDOPERACION" value="<?= $ID_OPERACION ?>">
<!-- FECHA -->
<input type="hidden" name="FECHA" value="<?= $FECHA ?>">
<!-- CAJERO -->
<input type="hidden" name="CAJERO" value="<?= $CAJERO ?>">
<!-- ID DE DEUDOR -->
<input id="DEUDOR" type="hidden" name="DEUDOR" value="<?= $DEUDOR_ID ?>">
<!-- CAJA -->
<input type="hidden" name="CAJA" value="<?= $CAJA ?>">

<!-- ESTADO COBRO POR DEFECTO "A" -->
<input type="hidden" name="ESTADO" value="A">
<!-- *********************CABECERA COBRO *****************-->







