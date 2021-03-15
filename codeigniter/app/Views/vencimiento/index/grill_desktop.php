<style>

  #OPERACIONES-CON-VENC  thead tr th:nth-child(1),#OPERACIONES-CON-VENC  tbody tr td:nth-child(1){
    width: 100px;
  }
  #OPERACIONES-CON-VENC  thead tr th:nth-child(5),#OPERACIONES-CON-VENC  tbody tr td:nth-child(5){
    width: 100px;
  }
  #OPERACIONES-CON-VENC  thead tr th:nth-child(7),#OPERACIONES-CON-VENC  tbody tr td:nth-child(7){
    width: 100px;
  }
</style>
<table id="OPERACIONES-CON-VENC" class="table table-bordered table-striped prestyle  ">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">


      <th></th>
      <th></th>
      <th></th>
      <th>M</th>
      <th>CÓD. OPE.</th>
      <th>FACTURA</th>
      <th class="text-right">CRÉDITO.</th>
      <th class="text-center">CÉDULA</th> 
      <th>NOMBRES</th>
    
    </tr>
  </thead>
  <tbody id="BUSCADO">

    <?php

    use App\Helpers\Utilidades;

    foreach ($OPERACION as $i) : ?>
      <tr id="<?= $i->IDNRO ?>">

        <td style='padding: 0px;'>
          <a  onclick="verCuotas(event)" class="btn btn-sm btn-primary m-0" href="<?= base_url("operacion/ver-vencimientos/" . $i->IDNRO) ?>">Ver cuotas</a>
        </td>
        <td  style='padding: 0px;'> 
          <a   href="<?= base_url("operacion/edit/". $i->IDNRO) ?>" ><i class="fa fa-edit" aria-hidden="true"></i></a>
        </td>
        <td  style='padding: 0px;'> 
          <a onclick="borrar(event)"  href="<?= base_url("operacion/delete/". $i->IDNRO) ?>" ><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>
        <td style='padding: 0px;'><?= $i->EMPRESA ?></td>
        <td style='padding: 0px;'><?= $i->LETRA.$i->CORRELATIVO ?></td>
        <td style='padding: 0px;'><?= ($i->FACTURA =="" ?  "*****" :  $i->FACTURA)?></td>
        <td class="text-right" style='padding: 0px;'><?=  Utilidades::number_f($i->CREDITO) ?></td>
        <td class="text-center" style='padding: 0px;'><?= $i->CEDULA ?></td> 
        <td style='padding: 0px;'><?=  $i->NOMBRES ?></td>
      
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
?>