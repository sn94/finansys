<table class="table table-sm table-striped table-hover table-info">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>CODIGO</th>
            <th>DESCRIPCIÓN</th>
            <th  class="text-right">INTERÉS %</th>
            <th  class="text-right">GAST. ADM %</th>
     
            <th  class="text-right">SEGURO_CANCEL</th>
            <th  class="text-right">SEGURO_3ROS</th>
            <th  class="text-right">MORA%</th>
            <th  class="text-right">PUNITORIO%</th>

        </tr>
    </thead>


    <tbody>

        <?php foreach ($producto_finan as $para) :  ?>
            <tr id="<?= 'row'.$para->IDNRO?>">
                <td>
                    <a href="<?= base_url("producto-finan/edit/$para->IDNRO") ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a onclick="borrarFila(event)" href="<?= base_url("producto-finan/delete/$para->IDNRO") ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
                <td> <?= $para->CODIGO_PRODUCTO ?> </td>
                <td> <?= $para->DESCRIPCION ?> </td>
                <td class="text-right"> <?= $para->INTERES_PORCE ?> </td>
                <td  class="text-right"> <?= $para->GAST_ADM_PORCE ?> </td>
                
                <td  class="text-right"> <?= $para->SEGURO_CANCEL ?> </td>
                <td  class="text-right"> <?= $para->SEGURO_3ROS ?> </td>
                <td class="text-right"> <?= $para->MORA_PORCE ?> </td>
                <td  class="text-right"> <?= $para->PUNITORIO_PORCE ?> </td>
            </tr>
        <?php endforeach;  ?>


    </tbody>
</table>

 