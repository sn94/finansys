<style>
   .card-title{
    font-size: 13.6px; 
   }
   .card-text{
    font-size: 12px !important; 
   }
  .card-title, .card-text {

    font-family: Arial, Helvetica, sans-serif;
  }
</style> 
 <?php

  use App\Helpers\Utilidades;

  foreach ($lista as $it) :  ?>






   <div class="card" style="width: 100%;">
     <div class="card-body pl-0 ml-0 pb-0 mb-0">
       <h5 class="card-title"> <?= $it->LETRA . $it->CORRELATIVO  ?> &nbsp;  <?= $it->NOMBRES ?> </h5>
 
       <p class="card-text">
         
         <b>CRÉDITO:</b><?= Utilidades::number_f($it->CREDITO) ?>
         <span class="bg-secondary m-0"> <?= Utilidades::number_f($it->CUOTA_IMPORTE) ?> X <?= $it->NRO_CUOTAS ?> cuotas</span>
       
       <div class="dropdown pt-0  mt-0">
         <button class="mt-0 btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           OPCIONES
         </button>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
           <a class="dropdown-item" href="<?= base_url("operacion/cobrar/" . $it->IDNRO) ?>">COBRAR </a>
           <a class="dropdown-item" href="<?= base_url("operacion/edit/" . $it->IDNRO) ?>">EDITAR</a>
           <a class="dropdown-item" onclick="borrar(event)" href="<?= base_url("operacion/delete/" . $it->IDNRO) ?>">BORRAR</a>
         </div>
       </div>
       </p>
     </div>
   </div>

 <?php endforeach; ?>



 </tbody>
 </table>