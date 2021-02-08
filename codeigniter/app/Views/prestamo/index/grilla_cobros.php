
<!-- ********************TABLA ***************** -->
<table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle" >
  <thead>
  <tr> <th></th><th>TITULAR</th><th>TOT.CUOTAS</th><th>PAGADAS</th><th>CAPITAL</th><th>SOLICITUD DE CRÉD.</th> </tr>
  </thead>
<tbody>
                       
<?php

use App\Helpers\Utilidades;

foreach($lista as $i):?>
  <tr id="<?=$i->IDNRO?>"    style="background-color: #ffffff;"  >
 
  <td><a class="btn btn-success btn-xs" href="<?=base_url("prestamo/cobro/$i->IDNRO")?>">COBRAR</a></td>
   <!--ENLACE DIRECTO PARA ACTUALIZAR DATOS DE DEUDOR --> 
  <td> <a href="<?=base_url("deudor/edit/$i->DEUDORID")?>"> <?=$i->DEUDOR?></a>  </td>

  <td>  <?=$i->TOTCUOTAS?>  </td>
  <td>  <?=$i->PAGADAS?>  </td>
  <td><?= Utilidades::number_f($i->MONTO_APROBADO)?></td>
  <td><?= Utilidades::from_timestamp( $i->FECHA_SOLICI  )?></td>
 
</tr>
<?php  endforeach;?>
                   
</tbody>
</table>
