 

      <!-- ********************TABLA ***************** -->
      <table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
        <thead class="dark-head">
          <tr style="font-family: mainfont;">
           
            <th></th>
            <th></th>
            <th>CI°/RUC</th>
            <th>NOMBRES/RAZÓN SOCIAL</th>
            <th>TELÉFONO</th>
            <th>FEC. SOLICITUD</th>
            <th>TIPO CRÉDITO</th>
            <th>ÚLT. ACT.</th>
          </tr>
        </thead>
        <tbody>

          <?php

          use App\Helpers\Utilidades;

          foreach ($lista as $i) : ?>
            <tr id="<?= $i->IDNRO ?>">

              
              <td><a href="<?= base_url("deudor/edit/$i->IDNRO") ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
              <td><a onclick="borrarFila(event)" href="<?= base_url("deudor/delete/$i->IDNRO") ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>

              <td><?= $i->CEDULA ?></td>
              <td><?= $i->NOMBRES ?></td>
              <td><?= $i->TELEFONO ?></td>
              <td><?=  Utilidades::fecha_f($i->FECHA_SOLICI )?></td>
              <td><?= $i->TIPO_CREDITO ?></td>
              <td><?= Utilidades::fecha_f($i->ULT_ACT) ?></td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
    
      <?=$pager->links()?>