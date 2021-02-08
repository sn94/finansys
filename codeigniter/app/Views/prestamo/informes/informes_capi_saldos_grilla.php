<?php

use App\Helpers\Utilidades;
?> 
<div id="grilla">


    <table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
        <thead>
            <tr><th>CLIENTE</th><th>CAPITAL</th><th>N° CUOTAS</th><th>CUOTA</th><th>CAPITAL FINAL</th><th>TOT. INTERÉS</th><th>TOT.PAGADO</th><th>SALDO</th></tr>
        </thead>
        <tbody>
            <?php foreach( $lista as $item): ?>
            <tr>
                <td><?=$item->CLIENTE?></td> 
                <td  class="text-right"><?= Utilidades::number_f( $item->CAPITAL)?></td>
                <td  class="text-center"><?= Utilidades::number_f( $item->NRO_CUOTAS)?></td>
                <td  class="text-right"><?= Utilidades::number_f( $item->CUOTA)?></td>
                <td  class="text-right"><?= Utilidades::number_f( $item->CAPITAL_FINAL)?></td>
                <td  class="text-right"><?= Utilidades::number_f( $item->TOT_INTERES)?></td>
                <td  class="text-right"><?= Utilidades::number_f( $item->TOT_PAGADO)?></td>
                <td class="text-right"><?= Utilidades::number_f( $item->SALDO)?></td>
               
            </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>
    <?php echo sizeof($lista) <= 0 ? "SIN REGISTROS" : "" ;?>
    <?= $enlaces->links() ?>
</div>

