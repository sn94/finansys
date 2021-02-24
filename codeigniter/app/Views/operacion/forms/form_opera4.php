<?php

$CUOTA_IMPORTE =    (isset($OPERACION) ?  $OPERACION->CUOTA_IMPORTE : "0");
$CAPITAL_DESEMBOLSO =    (isset($OPERACION) ?  $OPERACION->CAPITAL_DESEMBOLSO : "0");
$TOTAL_PRESTAMO =    (isset($OPERACION) ?  $OPERACION->TOTAL_PRESTAMO : "0");

?>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">CAPITAL (A DESEM.): </label>
    <input readonly style="grid-column-start: 2;" value="<?= $CAPITAL_DESEMBOLSO ?>" name="CAPITAL_DESEMBOLSO" ID="CAPITAL_DESEMBOLSO" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">MONTO PRÉSTAMO: </label>
    <input readonly style="grid-column-start: 2;"  value="<?= $TOTAL_PRESTAMO ?>" name="TOTAL_PRESTAMO" ID="MONTO-PRESTAMO" type="text" class="form-control entero">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">IMPORTE CUOTA: </label>
    <input readonly style="grid-column-start: 2;" value="<?= $CUOTA_IMPORTE ?>" id="CUOTA_IMPORTE" name="CUOTA_IMPORTE" type="text" class="form-control entero">
</div>