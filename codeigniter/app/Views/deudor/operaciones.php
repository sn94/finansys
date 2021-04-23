<?php

use App\Helpers\Utilidades;
use App\Models\Deudor_model;

//id cliente
$IDCLIENTE =   $CLIENTE;
$NOMBRECLIENTE = "";
$CEDULACLIENTE =  "";


if (!is_null($IDCLIENTE)) {
  $cliente = (new Deudor_model())->find($IDCLIENTE);
  $NOMBRECLIENTE =  $cliente->NOMBRES . " " . $cliente->APELLIDOS;
  $CEDULACLIENTE =  $cliente->CEDULA;
}
?>

<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
<?= $CEDULACLIENTE . "   " . $NOMBRECLIENTE   ?>
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<style>
  table tr th,
  table tbody tr td {
    padding: 0px !important;
  }
</style>

<table class="table table-bordered table-stripped table-info table-hover">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">

      <th>ID</th>
      <th>OPERACIÓN</th>
      <th>PRODUCTO</th>
      <th class="text-right">CRÉDITO</th>
      <th class="text-center">CUOTAS</th>
      <th>ESTADO</th>
      <th>CREADO</th>
      <th>ÚLT.MOD.</th>
    </tr>
  </thead>
  <tbody>

    <?php



    foreach ($OPERACION as $i) : ?>
      <tr id="<?= $i->IDNRO ?>">
        <td><?= $i->IDNRO ?></td>
        <td><?= $i->LETRA. $i->CORRELATIVO ?></td>
        <td><?= $i->PRODUCTO_FINANCIERO ?></td>
        <td class="text-right"><?= $i->CREDITO ?></td>
        <td class="text-center"><?= $i->NRO_CUOTAS ?></td>
        <td><?= $i->ESTADO ?></td>
        <td><?= Utilidades::fecha_f($i->REGISTRADO) ?></td>
        <td><?= Utilidades::fecha_f($i->ACTUALIZADO) ?></td>
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
?>
<?= $this->endSection() ?>