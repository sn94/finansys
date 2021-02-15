<table id="tabla-auxi" class="table table-bordered table-stripped prestyle">
    <thead class="dark-head">
        <tr style="font-family:mainfont; ">
            <th></th>
            <th></th>
            <th>LETRA</th>
            <th>ÚLT.NÚMERO</th>
            <th>CREADO</th>
            <th>MODIFICADO</th>
        </tr>
    </thead>
    <tbody>

        <?php

use App\Helpers\Utilidades;

foreach ($lista as $i) : ?>

            <tr id="<?= $i->IDNRO ?>">
                <td><a onclick="editarFila(event)" href="<?= base_url("letras/edit/" . $i->IDNRO) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                <td><a onclick="borrarFila(event)" href="<?= base_url("letras/delete/" . $i->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                <td> <?= $i->LETRA   ?> </td>
                <td> <?= $i->ULT_NUMERO   ?> </td>
                <td> <?= Utilidades::fecha_f( $i->created_at  ) ?> </td>
                <td> <?= Utilidades::fecha_f($i->updated_at)   ?> </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
<?=$pager->links()?>