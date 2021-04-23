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

<div class="row bg-primary rounded " >
 

  <div class="col-12 col-md-6">
    <h5 class="text-light">CÓD. OPERACIÓN: <?= $CODIGO_OPE ?></h5>
  </div>
  <div class="col-12 col-md-6">
    <h5 class="text-light">CI°: <?= $CEDULACLIENTE . "   " . $NOMBRECLIENTE   ?></h5>
  </div>
</div>
<table class="table table-bordered  table-hover table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">


      <th>N°</th>
      <th class="text-center">VENCIMIENTO</th>
      <th class="text-center">DIA</th>
      <th class="text-right">INTERÉS</th>
      <th class="text-right">IVA</th>
      <th class="text-right">CAPITAL</th>
      <th class="text-right">CUOTA</th>
      <th class="text-right">SALDO CAPITAL</th>
      <th  class="text-center">ESTADO</th>
    </tr>
  </thead>
  <tbody>

    <?php


$TOT_INTERES= 0;
$TOT_IVA= 0;
$TOT_CAPITAL= 0; 
    foreach ($cuotas as $i) :

      //Totales
      $TOT_INTERES+=  $i->INTERES;
      $TOT_IVA+=  $i->IVA;
      $TOT_CAPITAL+=  $i->CAPITAL;
     


      $NUMERO =  $i->NUMERO;
      $MONTO =  $i->MONTO ;
      $VENCIMIENTO = $i->VENCIMIENTO;
      $ESTADO = $i->ESTADO == "P" ?  "PENDIENTE" : "PAGADO";
      $DIA =  $i->DIA;
      $IVA =  Utilidades::number_f($i->IVA);
      $CAPITAL =  Utilidades::number_f($i->CAPITAL);
      $INTERES = Utilidades::number_f($i->INTERES);
      $SALDO =  Utilidades::number_f($i->SALDO);
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
        <td class="p-0 text-center"><?= $ESTADO ?></td>

      </tr>

    <?php endforeach; ?>



  <tfoot>
    <tr class="table-info">
      <td class="p-0 text-right"></td>
      <td class="p-0 text-right"></td>
      <td class="p-0 text-right"></td>
      <td class="p-0 text-right"><?= Utilidades::number_f($TOT_INTERES) ?></td>
      <td class="p-0 text-right"> <?= Utilidades::number_f($TOT_IVA) ?> </td>
      <td  class="p-0 text-right"> <?= Utilidades::number_f($TOT_CAPITAL) ?></td>
      <td  class="p-0 text-right"> <?= $i->TOTAL_MONTO_CUOTA ?> </td>
      <td class="p-0 text-right"></td>
      <td class="p-0 text-right" ></td>
    </tr>

  </tfoot>
  </tbody>
</table>
<?= $pager->links()
?>