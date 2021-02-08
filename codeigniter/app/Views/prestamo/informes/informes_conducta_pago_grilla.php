<?php

use App\Helpers\Utilidades;
?> 
<div id="grilla">


    <table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
        <thead>
            <tr><th>CI/RUC</th><th>CLIENTE</th><th>CUOTAS REGULARES</th><th>CUOTAS ATRASADAS</th> </tr>
        </thead>
        <tbody>
            <?php foreach( $lista as $item): ?>
            <tr>
                <td><?=  $item->{'CI/RUC'}?></td>
                <td><?=   $item->CLIENTE ?></td>
                <td><?= $item->PAGO_REGULAR ?></td>
                <td><?= $item->PAGO_ATRASADO?></td> 
            </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>
    <?php echo sizeof($lista) <= 0 ? "SIN REGISTROS" : "" ;?>
    <?= $enlaces->links() ?>
</div>

