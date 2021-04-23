<style>

table tr th,
  table tbody tr td {
    padding: 0px !important;
  }
</style>

<table class="table table-bordered table-striped table-hover table-info">

<thead>
  <tr style="font-family: textfont;">
    <th></th>
    <th></th>
     <th></th>
  
    <th>OPERACIÓN</th>
    <th>COD. OPE.</th>
    <th class="text-right">CRÉDITO</th>
    <th class="text-center">CUOTAS</th>
    <th>N° CLIENTE</th>
    <th>CI°</th>
    <th>NOMBRES,APELLIDOS</th>
  </tr>
</thead>

<tbody id="TABLE-BODY">

  <?php

use App\Helpers\Utilidades;

foreach ($lista as $it) :  ?>
    <tr>
      <td class="p-0">
        <a class="btn btn-primary btn-sm" href="<?= base_url("operacion/aprobar/" . $it->IDNRO) ?>">APROBAR </a>
      </td>
      <td  class="p-0">
        <a  href="<?= base_url("operacion/edit/" . $it->IDNRO) ?>" ><i class="fa fa-edit" aria-hidden="true"></i></a>
      </td>
      <td  class="p-0">
        <a onclick="borrar(event)" href="<?= base_url("operacion/delete/" . $it->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
      </td>
     
      <td  class="p-0"><?= $it->IDNRO ?></td>
      <td  class="p-0"><?= $it->LETRA.$it->CORRELATIVO  ?></td>
      <td  class="text-right p-0"><?= Utilidades::number_f($it->CREDITO) ?></td>
      <td  class="text-center p-0"><?= $it->NRO_CUOTAS ?></td>
      <td  class="p-0"><?= $it->NRO_CLIENTE ?></td>
      <td  class="p-0"><?= $it->CEDULA ?></td>
      <td  class="p-0"><?= $it->NOMBRES ?></td>
    </tr>
  <?php endforeach; ?>



</tbody>
</table>