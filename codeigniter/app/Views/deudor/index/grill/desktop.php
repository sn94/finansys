<style>
  table tr th,
  table tbody tr td {
    padding: 0px !important;
  }

  table td>* {
    color: #383838;
  }
</style>


<?php
$COLUMNS =  ["", "",  "CI°/RUC", "NOMBRES/RAZÓN SOCIAL", "TELÉFONO", "FEC. SOLICI.", "TIPO CRÉD.", "ÚLT. ACT."];
?>

<!-- ********************TABLA ***************** -->
<table id="tabla-funcionarios" class="mt-2 table table-bordered table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: textfont;">
      <?php foreach ($COLUMNS as $COL) : ?>
        <th><?=$COL?></th>
      <?php endforeach; ?> 
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
        <td><?= Utilidades::fecha_f($i->FECHA_SOLICI) ?></td>
        <td><?= $i->TIPO_CREDITO ?></td>
        <td><?= Utilidades::fecha_f($i->ULT_ACT) ?></td>
        
      </tr>

    <?php endforeach; ?>

  </tbody>
</table>

<?= $pager->links() ?>