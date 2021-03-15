<style>
  table thead tr th,   table tbody tr td{
    padding: 0px !important;
    font-family: textfont; font-size: 12px;
  }

  table tbody tr td{
  font-size: 12.5px;
  font-weight: 600;
  color:#404040;
  }

  table tr th:nth-child(1), table tr th:nth-child(1){
width: 95px;
  }
  table tr th:nth-child(6), table tr th:nth-child(6){
width: 95px;
  }
</style>
<table class="table table-bordered table-striped table-hover">

<thead>
  <tr>
    <th></th>
    <th></th>
     <th></th>
     <th>CÓD.</th> 
    <th>CLIENTE</th>
    <th>OPERACIÓN</th>
    <th class="text-right">CRÉDITO</th>
    <th class="text-right">IMP. CUOTA</th>
    <th class="text-center">CUOTAS</th>
    <th>NOMBRES,APELLIDOS</th>
    <th>FECHA</th>
  </tr>
</thead>

<tbody id="TABLE-BODY">

  <?php

use App\Helpers\Utilidades;

foreach ($lista as $it) :  ?>
    <tr>
      <td class="p-0">
        <a class="btn btn-primary btn-sm" href="<?= base_url("operacion/cobrar/" . $it->IDNRO) ?>">COBRAR </a>
      </td>
      <td  class="p-0">
        <a  href="<?= base_url("operacion/edit/" . $it->IDNRO) ?>" ><i class="fa fa-edit" aria-hidden="true"></i></a>
      </td>
      <td  class="p-0">
        <a onclick="borrar(event)" href="<?= base_url("operacion/delete/" . $it->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
      </td>
      <td  class="p-0"><?= $it->LETRA.$it->CORRELATIVO  ?></td>
 
      <td  class="p-0"><?= $it->NRO_CLIENTE ?></td>
      <td  class="p-0"><?= $it->IDNRO ?></td>
      <td  class="text-right p-0"><?= Utilidades::number_f($it->CREDITO) ?></td>
      <td  class="text-right p-0"><?=Utilidades::number_f( $it->CUOTA_IMPORTE) ?></td>
      <td  class="text-center p-0"><?= $it->NRO_CUOTAS ?></td>
      <td  class="p-0"><?= $it->NOMBRES ?></td>
      <td  class="p-0"><?= Utilidades::fecha_f($it->created_at) ?></td>
    </tr>
  <?php endforeach; ?>



</tbody>
</table>