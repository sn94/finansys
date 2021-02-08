<?php

use App\Helpers\Utilidades;
?> 
<div id="grilla">


    <table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
        <thead>
            <tr><th>CAPITAL</th><th>CUOTA N°</th><th>CUOTA</th><th>SALDO</th><th>VENCIMIENTO</th><th>FECHA PAGO</th><th>CLIENTE</th><th>ESTADO</th> </tr>
        </thead>
        <tbody>
            <?php foreach( $lista as $item): ?>
            <tr>
            <td><?= Utilidades::number_f( $item->CAPITAL)?></td>
                <td><?= $item->NUMERO?></td>
                <td><?= Utilidades::number_f( $item->CUOTA)?></td>
                <td><?= Utilidades::number_f( $item->SALDO)?></td>
                <td><?= Utilidades::fecha_f( $item->VENCIMIENTO)?></td>
                <td><?= Utilidades::fecha_f( $item->FECHA_PAGO)?></td>
                <td><?= $item->CLIENTE?></td>  
                <td><?= $item->ESTADO?></td> 
            </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>
    <?php echo sizeof($lista) <= 0 ? "SIN REGISTROS" : "" ;?>
    <?= $enlaces->links() ?>
</div>

