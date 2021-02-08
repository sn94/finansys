<?php

use App\Helpers\Utilidades;
?> 
<div id="grilla">


    <table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
        <thead>
            <tr><th>FECHA</th><th>COBRADO</th><th>EFECTIVO</th><th>CHEQUE</th><th>TARJETA</th><th>CLIENTE</th><th>CAJA</th><th>CAJERO</th></tr>
        </thead>
        <tbody>
            <?php foreach( $lista as $item): ?>
            <tr>
                <td><?= Utilidades::fecha_f( $item->FECHA)?></td>
                <td><?= Utilidades::number_f( $item->TOTAL)?></td>
                <td><?= Utilidades::number_f( $item->EFECTIVO)?></td>
                <td><?= Utilidades::number_f( $item->CHEQUE)?></td>
                <td><?= Utilidades::number_f( $item->TARJETA)?></td>
                <td><?= $item->CLIENTE?></td>
                <td><?= $item->CAJA?></td>
                <td><?=$item->CAJERO?></td>
            </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>
    <?php echo sizeof($lista) <= 0 ? "SIN REGISTROS" : "" ;?>
    <?= $enlaces->links() ?>
</div>

