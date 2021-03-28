<style>

#COBROS-GRILL {
  font-size: 12px;
}
 
</style>


<table id="COBROS-GRILL" class="table table-bordered table-striped table-hover">

<thead>
  <tr style="font-family: textfont;">
 
    <th  class=" p-0">FECHA</th> 
    <th class="text-center p-0">OPERACIÓN</th>
    <th  class=" p-0">CI°</th>
    <th  class=" p-0">NOMBRES,APELLIDOS</th>
    <th  class="text-right p-0">CRÉDITO</th>
    <th  class="text-right p-0">N° CUOTAS</th>
    <th  class="text-right p-0">CUOTAS PAG.</th>
    <th class="text-right p-0">TOTAL</th> 
  </tr>
</thead>

<tbody id="TABLE-BODY">

  <?php
 
 
foreach ($COBRO as $it) :  ?>
    <tr> 
      <td  class="p-0"><?= $it->FECHA?></td> 
      <td  class="text-center p-0"><?= $it->COD_OPE ?></td>
      <td  class="text-center p-0"><?= $it->CEDULA ?></td>
      <td  class="text-center p-0"><?= $it->NOMBRES ?></td>
      <td  class="text-right p-0"><?=  $it->CREDITO ?></td>
      <td  class="text-right p-0"><?=  $it->NRO_CUOTAS ?></td>
      <td  class="text-right p-0 "><?= $it->CUOTAS_PAGADAS ?></td>
      <td  class="text-right p-0 "><?= $it->TOTAL_COBRO ?></td>
    </tr>
  <?php
 
endforeach; 

$TOTAL_COBRADO=  isset( $COBRO[0] ) ? $COBRO[0]->TOTAL_COBRADO  :  "0";
?>

</tbody>

<tfoot>
<tr>
<td class="text-right p-0"></td>
<td class="text-right p-0"></td>
<td class="text-right p-0"></td>
<td class="text-right p-0"></td>
<td class="text-right p-0"></td>
<td class="text-right p-0"></td>
<td class="text-right p-0">TOTAL:</td>
<td class="text-right p-0"><?= $TOTAL_COBRADO?></td> 
</tr>
</tfoot>
</table>
<?= $pager->links()
?>