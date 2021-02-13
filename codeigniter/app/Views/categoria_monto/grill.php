   <!-- ******************* CAJA  ***************** -->
   <table id="tabla-auxi" class="table table-bordered table-stripped">
       <thead class="dark-head">
           <tr style="font-family: mainfont;">
               <th></th>
               <th></th>
               <th>MONTO</th>
               <th>NRO CUOTAS</th>
               <th>CUOTA</th>
               <th>FORMATO</th>
           </tr>
       </thead>
       <tbody>

           <?php

            use App\Helpers\Utilidades;

            foreach ($lista as $i) : ?>

               <tr id="<?= $i->IDNRO ?>">
                   <td><a onclick="editarFila(event)" href="<?= base_url("categoria_monto/edit/" . $i->IDNRO) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                   <td><a onclick="borrarFila(event)" href="<?= base_url("categoria_monto/delete/" . $i->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                   <td> <?= Utilidades::number_f($i->MONTO) ?></td>
                   <td> <?= $i->NRO_CUOTAS ?></td>
                   <td> <?= Utilidades::number_f($i->CUOTA) ?></td>
                   <td> <?= $i->FORMATO == "D" ? "DIARIO" : ($i->FORMATO == "S" ? "SEMANAL" : ($i->FORMATO == "Q" ? "QUINCENAL" : "MENSUAL"))   ?></td>
               </tr>

           <?php endforeach; ?>

       </tbody>
   </table>

   <?= $pager->links() 
   
   
   ?>
 