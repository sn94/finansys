 <table class="table table-bordered table-stripped prestyle  ">
    
   <tbody id="BUSCADO">

     <?php

      use App\Helpers\Utilidades;

      foreach ($OPERACION as $i) : ?>
       <tr id="<?= $i->IDNRO ?>">


         <td>
           <div class="dropdown">
             <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones
             </button>
             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
               <a onclick="verCuotas(event)" class="dropdown-item" href="<?= base_url("operacion/cuotas/" . $i->IDNRO) ?>">Cuotas</a>
               <a class="dropdown-item"   href="<?= base_url("operacion/edit/" . $i->IDNRO) ?>">Editar operación</a>
               <a class="dropdown-item" onclick="borrar(event)" href="<?= base_url("operacion/delete/" . $i->IDNRO) ?>"> Borrar operación</a>

             </div>
           </div>
         </td>
      
         <td style='padding: 0px;'>
         
        <b> <?= $i->LETRA . $i->CORRELATIVO ?></b> &nbsp;&nbsp; <b>CI°: </b><?= $i->CEDULA ?>&nbsp;<b>CRÉDITO:</b><?= Utilidades::number_f($i->CREDITO) ?>
         <p class="m-0 p-0"><?= $i->NOMBRES ?>&nbsp;&nbsp; </p>
          </td>
         
 
         
       </tr>

     <?php endforeach; ?>
   </tbody>
 </table>
 <?= $pager->links()
  ?>