<table id="tabla-auxi" class="table table-bordered table-stripped prestyle">
    <thead class="dark-head">
        <tr>
            <th></th>
            <th></th>
            <th>PORCENTAJE</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($lista as $i) : ?>

            <tr id="<?= $i->IDNRO ?>">
                <td><a onclick="editarFila(event)" href="<?= base_url("porcentaje/edit/" . $i->IDNRO) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                <td><a onclick="borrarFila(event)" href="<?= base_url("porcentaje/delete/" . $i->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                <td> <?= $i->PORCENTAJE != "" ? $i->PORCENTAJE : "****"  ?> </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
<?=$pager->links()?>