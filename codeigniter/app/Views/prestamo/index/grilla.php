<!-- ********************TABLA ***************** -->
<table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
  <thead>
    <tr style="font-family: mainfont;">

      <th></th>
      <th></th>
      <th> </th>
      <th></th>
      <!--Aprobar  --Rechazar --(Solo si el estado esta Pendiente )-->


      <th>TITULAR</th>
      <th>TOT.CUOTAS</th>
      <th>PAGADAS</th>
      <th>MONTO SOLICITADO</th>
      <th>SOLICITUD</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <tbody>

    <?php

    use App\Helpers\Utilidades;

    foreach ($lista as $i) : ?>
      <tr id="<?= $i->IDNRO ?>" class=" <?= $i->ESTADO == "P"  ? "table-secondary" : ($i->ESTADO == "A" ? "table-success" : ($i->ESTADO == "L" ? "table-primary" : "table-danger"))  ?>">

        <!-- EDIT -->
        <td >
          <?php if ($i->ESTADO != "L" && $i->ESTADO != "R") : ?>
            <a style="color: black;margin: 0px; padding:0px;" href="<?= base_url("prestamo/edit/$i->IDNRO") ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
          <?php endif; ?>
        </td>
        <!-- BORRAR -->
        <td><a style="color: black;margin: 0px; padding:0px;" onclick="borrarFila(event)" href="<?= base_url("prestamo/delete/$i->IDNRO") ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        <!-- OPCIONES DE APROBAR O RECHAZAR -->


        <?php if ($i->ESTADO == "P") : ?>
          <td><a style="color: green;margin: 0px; padding:0px;" class="icon-success" href="<?= base_url("prestamo/aprobar/$i->IDNRO") ?>"><i class="fa fa-check-circle" aria-hidden="true"></i></a></td>
          <td><a style="color: red;margin: 0px; padding:0px;" onclick="rechazarSolicitud(event)" class="icon-danger" href="<?= base_url("prestamo/rechazar/$i->IDNRO") ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

        <?php elseif ($i->ESTADO == "A") : ?>
          <td><a href="<?= base_url("prestamo/cobro/$i->IDNRO") ?>"><i class="fa fa-money" aria-hidden="true"></i></a></td>
          <td></td>
        <?php else : ?>
          <td></td>
          <td></td>
        <?php endif; ?>
        <!--ENLACE DIRECTO PARA ACTUALIZAR DATOS DE DEUDOR -->
        <td> <a href="<?= base_url("deudor/edit/$i->DEUDORID") ?>"> <?= $i->DEUDOR ?></a> </td>

        <td> <?= $i->TOTCUOTAS ?> </td>
        <td> <?= $i->PAGADAS ?> </td>
        <td class="text-right"><?= Utilidades::number_f($i->MONTO_SOLICI) ?></td>
        <td><?= Utilidades::from_timestamp($i->FECHA_SOLICI) ?></td>
        <td><?= $i->ESTADO == "P" ? "PENDIENTE" : ($i->ESTADO == "A" ? "APROBADO" : ($i->ESTADO == "L" ? "LIQUIDADO" : "RECHAZADO"))  ?></td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>