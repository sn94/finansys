<?php

use App\Helpers\Utilidades;

$NOMBRECLIENTE=  isset($CLIENTE)? $CLIENTE->NOMBRES." ".$CLIENTE->APELLIDOS  :  "";
$CEDULACLIENTE=  isset($CLIENTE)? $CLIENTE->CEDULA :  "";
?> 

<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
<?=  $CEDULACLIENTE."   ". $NOMBRECLIENTE   ?>
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>




<table class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">

       
      <th>OPERACIÓN</th> 
      <th>CRÉDITO</th>
      <th>CUOTAS</th> 
      <th>NOMBRES</th>
      <th>CREADO</th>
      <th>ÚLT.MOD.</th>
    </tr>
  </thead>
  <tbody>

    <?php



    foreach ($OPERACION as $i) : ?>
      <tr id="<?= $i->IDNRO ?>">
        <td><?= $i->IDNRO ?></td>
        <td><?= $i->CREDITO ?></td>
        <td><?= $i->CUOTAS ?></td>
        <td><?= $i->ESTADO ?></td>
        <td><?= Utilidades::fecha_f($i->created_at) ?></td>
        <td><?= Utilidades::fecha_f($i->updated_at) ?></td>
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
    ?>
<?= $this->endSection() ?>