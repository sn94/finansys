<?php

use App\Helpers\Utilidades;
?>
 

<div style="font-size: 11pt; color:#363636;margin-top: 10pt;font-family:Verdana, Geneva, Tahoma, sans-serif;" class="container col-xs-12 col-md-offset-3 col-md-6">
<h4  >ESTADO DE CUENTA ACTUAL:</h4>
<dl class="row">
<dt class="col-xs-12 col-md-2">CI°/RUC:</dt><dd class="col-xs-12 col-md-9"><?=$CI_RUC?></dd>
<dt class="col-xs-12 col-md-2">NOMBRE COMPLETO:</dt><dd class="col-xs-12 col-md-9"><?=$NOMBRES?></dd>
  <dt class="col-xs-12 col-md-2">DEUDA TOTAL</dt><dd class="col-xs-12 col-md-9"><?= Utilidades::number_f($DEUDA_TOTAL)?></dd>
  <dt class="col-xs-12 col-md-2">TOTAL CUOTAS</dt><dd class="col-xs-12 col-md-9"><?=$NRO_CUOTAS?></dd>
  <dt class="col-xs-12 col-md-2">PAGADAS</dt><dd class="col-xs-12 col-md-9"><?=$PAGADAS?></dd>
  <dt class="col-xs-12 col-md-2">PENDIENTES</dt><dd class="col-xs-12 col-md-9"><?=$PENDIENTES?></dd>
</dl>


<?php  if( isset( $id_recibo ) ):  ?>
<a onclick="printBill(event)" href="<?=base_url("prestamo/mostrarRecibo/$id_recibo")?>"><i class="fa fa-print fa-lg"></i>Imprimir Recibo</a>
<?php  endif; ?>

</div>