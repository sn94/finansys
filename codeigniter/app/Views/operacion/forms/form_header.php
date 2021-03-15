<?php

use App\Models\Empresa_model; 

$IDNRO_OPERACION = isset($OPERACION) ? $OPERACION->IDNRO : "";
$EMPRESA =   isset($OPERACION) ? $OPERACION->EMPRESA : "1"; //Se debe obtener de la sesion
$EMPRESA_NOM =  (new Empresa_model())->find($EMPRESA)->DESCR;
$FUNCIONARIO = session("ID");
?>


<div class=" row  mr-md-5 ml-md-5 mb-0 pt-0  bg-primary text-center" style=" color:beige;">

    <div class="col-12 col-md-4 ">
        <h5 class="text-light">EMPRESA: <?= $EMPRESA_NOM ?></h5>
    </div>
    <div class="col-12 col-md-4">

        <?php if (isset($OPERACION)) : ?>
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">N° OPERACIÓN </label>
                <input readonly style="grid-column-start: 2;" type="text" class="form-control" value="<?= $IDNRO_OPERACION ?>">
            </div>
        <?php endif; ?>
    </div>



</div>
<input type="hidden" name="EMPRESA" value="<?= $EMPRESA ?>">

<input type="hidden" name="FUNCIONARIO" value="<?= $FUNCIONARIO ?>">