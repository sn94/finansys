 
      <!-- ******************* CAJA  ***************** -->
      <table id="tabla-auxi" class="table table-bordered table-stripped">
        <thead class="dark-head">
          <tr style="font-family: mainfont;">
            <th></th>
            <th></th>
            <th>DESCRIPCIÓN</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($lista as $i) : ?>

            <tr id="<?= $i->IDNRO ?>">
              <td><a onclick="editarFila(event)" href="<?= base_url("empresa/edit/" . $i->IDNRO) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
              <td><a onclick="borrarFila(event)" href="<?= base_url("empresa/delete/" . $i->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
              <td> <?= $i->DESCR != "" ? $i->DESCR : "****"  ?> </td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
    