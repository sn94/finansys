<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>BCP %</th>
         
            <th>GAST. ADM %</th>
            <th>DIASXMES</th>
            <th>DIASXANIO</th>
            <th>IVA</th>
            <th>MESESXANIO</th>
            <th>SEGURO_CANCEL</th>
            <th>SEGURO_3ROS</th>
            <th>MORA%</th>
            <th>PUNITORIO%</th>

        </tr>
    </thead>


    <tbody>

        <?php foreach ($parametros as $para) :  ?>
            <tr>
                <td> <?= $para->CODIGO_PRODUCTO ?> </td>
                <td> <?= $para->BCP_INTERES ?> </td>
              
                <td> <?= $para->GAST_ADM_PORCE ?> </td>
                <td> <?= $para->DIASXMES ?> </td>
                <td> <?= $para->DIASXANIO ?> </td>
                <td> <?= $para->IVA ?> </td>
                <td> <?= $para->MESESXANIO ?> </td>
                <td> <?= $para->SEGURO_CANCEL ?> </td>
                <td> <?= $para->SEGURO_3ROS ?> </td>
                <td> <?= $para->MORA_PORCE ?> </td>
                <td> <?= $para->PUNITORIO_PORCE ?> </td>
            </tr>
        <?php endforeach;  ?>


    </tbody>
</table>