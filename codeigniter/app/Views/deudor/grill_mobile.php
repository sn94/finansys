<style>
   .card-title{
    font-size: 15px; 
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

foreach ($lista as $i) :


$TELEFONO=  $i->TELEFONO== ""?  "****": $i->TELEFONO; 
$TIPOCREDITO=   $i->TIPO_CREDITO== ""?  "****":  $i->TIPO_CREDITO; 
?>


  <div class="card p-0" style="width: 100%;">
    <div class="card-body">


      <p  class="card-title text-primary"> <?= $i->NOMBRES ?></p>

      <p class="card-text p-0 m-0">
      <b>CI°.:</b> <?= $i->CEDULA ?> &nbsp; <b>FECHA SOLICI.:</b><?= Utilidades::fecha_f($i->FECHA_SOLICI) ?>
      </p>
      <p class="card-text mt-0">
        <b>TELÉF.:</b><?=$TELEFONO?> &nbsp;&nbsp; <b>TIPO CRÉD.:</b> <?= $TIPOCREDITO ?>
      </p>



      <a href="#" class="card-link">
        <a href="<?= base_url("deudor/edit/$i->IDNRO") ?>"><i class="fa fa-edit" aria-hidden="true"></i>EDITAR</a>
        &nbsp;
        <a onclick="borrarFila(event)" href="<?= base_url("deudor/delete/$i->IDNRO") ?>">
        <i class="fa fa-trash" aria-hidden="true"></i>BORRAR</a>

      </a>
    </div>
  </div>





<?php endforeach; ?>

</tbody>
</table>

<?= $pager->links() ?>