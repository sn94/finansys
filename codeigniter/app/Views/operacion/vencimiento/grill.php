<table class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
    <tr style="font-family: mainfont;">


      <th></th>
      <th>OPERACIÓN</th>
      <th>NOMBRES</th>
      <th>CRÉDITO</th>
      <th>CUOTAS</th>
      <th>ESTADO</th>
      <th>CREADO</th>
      <th>ÚLT.MOD.</th>
    </tr>
  </thead>
  <tbody id="BUSCADO">

    <?php

    use App\Helpers\Utilidades;

    foreach ($OPERACION as $i) : ?>
      <tr id="<?= $i->IDNRO ?>">

        <td style='padding: 0px;'>
          <?php if ($i->ESTADO == "APROBADO") : ?>
            <a class="btn btn-sm btn-primary" href="<?= base_url("operacion/generar-vencimiento/" . $i->IDNRO) ?>">Generar</a>
            <?php else: ?>
              <a class="btn btn-sm btn-primary" href="<?= base_url("operacion/ver-vencimientos/" . $i->IDNRO) ?>">Ver cuotas</a>
            <?php endif; ?>
        </td>
        <td style='padding: 0px;'><?= $i->IDNRO ?></td>
        <td style='padding: 0px;'><?= $i->NOMBRES ?></td>
        <td style='padding: 0px;'><?= Utilidades::number_f($i->CREDITO) ?></td>
        <td style='padding: 0px;'><?= $i->CUOTAS ?></td>
        <td style='padding: 0px;'><?= $i->ESTADO ?></td>
        <td style='padding: 0px;'><?= Utilidades::fecha_f($i->created_at) ?></td>
        <td style='padding: 0px;'><?= Utilidades::fecha_f($i->updated_at) ?></td>
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
<?= $pager->links()
?>