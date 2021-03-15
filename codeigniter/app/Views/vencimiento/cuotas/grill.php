<?php

use App\Helpers\Utilidades;
use App\Models\Deudor_model;


$CODIGO_OPE =  $OPERACION->LETRA  . $OPERACION->CORRELATIVO;

//id cliente
$IDCLIENTE =   $OPERACION->NRO_CLIENTE;
$NOMBRECLIENTE = "";
$CEDULACLIENTE =  "";


if (!is_null($IDCLIENTE)) {
  $cliente = (new Deudor_model())->find($IDCLIENTE);
  $NOMBRECLIENTE =  $cliente->NOMBRES . " " . $cliente->APELLIDOS;
  $CEDULACLIENTE =  $cliente->CEDULA;
}
?>

<div class="row" style="background-color: #303f9f; color: white !important;">

  <div class="col-12 col-md-2">
    
  </div>

  <div class="col-12 col-md-4">
    <label style="font-family: Arial;" class="text-light">CÓD. OPERACIÓN: <?= $CODIGO_OPE ?> </label>
  </div>
  <div class="col-12 col-md-6">
    <label  style="font-family: Arial;"  class="text-light">CI°: <?= $CEDULACLIENTE . "   " . $NOMBRECLIENTE   ?></label>
  </div>
</div>
<table class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">


      <th>N°</th>
      <th class="text-center">VENCIMIENTO</th>
      <th class="text-right">DIA</th>
      <th class="text-right">INTERÉS</th>
      <th class="text-right">IVA</th>
      <th class="text-right">CAPITAL</th>
      <th class="text-right">CUOTA</th>
      <th class="text-right">SALDO CAPITAL</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <tbody>

    <?php
 

    foreach ($cuotas as $i) :
      $NUMERO =  $i->NUMERO;
      $MONTO = Utilidades::number_f($i->MONTO);
      $VENCIMIENTO = Utilidades::fecha_f($i->VENCIMIENTO);
      $ESTADO = $i->ESTADO == "P" ?  "PENDIENTE" : "PAGADO";
      $DIA=  $i->DIA;
      $IVA=  Utilidades::number_f(  $i->IVA );
      $CAPITAL=  Utilidades::number_f(  $i->CAPITAL );
      $INTERES= Utilidades::number_f( $i->INTERES);
      $SALDO=  Utilidades::number_f($i->SALDO);
    ?>
      <tr id="<?= $i->IDNRO ?>">
        <td class="p-0"><?= $NUMERO ?></td>
        <td class="p-0 text-center"><?= $VENCIMIENTO ?></td>
        <td class="p-0 text-center"><?= $DIA ?></td>
        <td class="p-0 text-right"><?= $INTERES ?></td>
        <td class="p-0 text-right"><?= $IVA ?></td>
        <td class="p-0 text-right"><?= $CAPITAL ?></td>
        <td class="text-right p-0"><?= $MONTO ?></td>
        <td class="p-0 text-right"><?= $SALDO ?></td>
        <td class="p-0"><?= $ESTADO ?></td>

      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
?>