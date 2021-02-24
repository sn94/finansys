<?php

use App\Helpers\Utilidades;
use App\Models\Deudor_model;


$CODIGO_OPE =  $OPERACION->LETRA . "-" . $OPERACION->CORRELATIVO;

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

<div class="row" style="background-color: #303f9f; color: white;">

  <div class="col-12 col-md-3">
    
  </div>

  <div class="col-12 col-md-3">
    <h4>CÓD. OPERACIÓN: <?= $CODIGO_OPE ?> </h4>
  </div>
  <div class="col-12 col-md-6">
    <h4>CI°: <?= $CEDULACLIENTE . "   " . $NOMBRECLIENTE   ?></h4>
  </div>
</div>
<table class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">


      <th>N°</th>
      <th class="text-right">MONTO</th>
      <th class="text-center">VENCIMIENTO</th>
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
    ?>
      <tr id="<?= $i->IDNRO ?>">
        <td class="p-0"><?= $NUMERO ?></td>
        <td class="text-right p-0"><?= $MONTO ?></td>
        <td class="p-0 text-center"><?= $VENCIMIENTO ?></td>
        <td class="p-0"><?= $ESTADO ?></td>

      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
?>