<?php

use App\Models\Empresa_model;
use App\Models\Letras_model;

$EMPRESA =   isset($OPERACION) ? $OPERACION->EMPRESA : "1"; //Se debe obtener de la sesion
$EMPRESAS =  (new Empresa_model())->list_dropdown();
$LETRAS = (new Letras_model())->list_dropdown();
?>

<div class="row">


    <div class="col-12  col-md-4">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CÓDIGO OPERACIÓN: </label>
            <?php echo form_dropdown("", $LETRAS,  '', ['id' => 'LETRAS', 'class' => "form-control", "onchange" => "generar_codigo_operacion(this)"]);  ?>
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">LETRA: </label>
            <input readonly style="grid-column-start: 2;" name="LETRA" type="text" class="form-control">
        </div>
    </div>


    <div class="col-12  col-md-4">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">CORRELATIVO: </label>
            <input readonly style="grid-column-start: 2;" name="CORRELATIVO" type="text" class="form-control">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">N° FACTURA: </label>
            <input maxlength="15" style="grid-column-start: 2;" id="FACTURA" type="text" class="form-control entero">
        </div>
    </div>


    <div class="col-12  col-md-4">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">EMPRESA :</label>
            <?php echo form_dropdown("EMPRESA", $EMPRESAS,  $EMPRESA, ['class' => "form-control"]);  ?>
        </div>
    </div>




</div>