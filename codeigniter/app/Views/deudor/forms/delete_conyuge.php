<?php
$CEDULA_CONYU =  !isset($deudor_dato) ? "" :  $deudor_dato->CEDULA_CONYU;
$CONYUGE = !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE;
$CONYUGE_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_TELEF;
$CONYUGE_SUELDO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_SUELDO;
$CONYUGE_OCUPACION =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_OCUPACION;
$CONYUGE_ANTIGUEDAD =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_ANTIGUEDAD;
$CONYUGE_EMPRESA =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_EMPRESA;
$CONYUGE_TEL_TRABAJO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_TEL_TRABAJO;
$CONYUGE_DIR_TRABAJO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_DIR_TRABAJO;
$CONYUGE_CARGO_TRABAJO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_CARGO_TRABAJO;
$CONYUGE_UNIDAD_TRABAJO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_UNIDAD_TRABAJO;

?>
<fieldset>
    <legend>CÓNYUGE</legend>



   


    <div class="row p-1">
        <div class="col-12 col-md-2">

            <div class="form-group">
                <label>CI° CÓNYUGE:</label>
                <input oninput="input_number_millares(event)" maxlength="8" name="CEDULA_CONYU" type="text" class="form-control numerico" value="<?= $CEDULA_CONYU ?>">
            </div>

        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>NOMBRE DE CÓNYUGE:</label>
                <input maxlength="50" name="CONYUGE" type="text" class="form-control" value="<?= $CONYUGE ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TELÉF.:</label>
                <input maxlength="20" name="CONYUGE_TELEF" type="text" class="form-control" value="<?= $CONYUGE_TELEF ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>OCUPACIÓN:</label>
                <input maxlength="20" name="CONYUGE_OCUPACION" type="text" class="form-control" value="<?= $CONYUGE_OCUPACION ?>">
            </div>

        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>ANTIGUEDAD:</label>
                <input maxlength="2" name="CONYUGE_ANTIGUEDAD" type="text" class="form-control numerico" value="<?= $CONYUGE_ANTIGUEDAD ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>EMPRESA:</label>
                <input maxlength="20" name="CONYUGE_EMPRESA" type="text" class="form-control" value="<?= $CONYUGE_EMPRESA ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TELÉFONO LABORAL:</label>
                <input maxlength="20" name="CONYUGE_TEL_TRABAJO" type="text" class="form-control" value="<?= $CONYUGE_TEL_TRABAJO ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>DIRECCIÓN:</label>
                <input maxlength="50" name="CONYUGE_DIR_TRABAJO" type="text" class="form-control" value="<?= $CONYUGE_DIR_TRABAJO ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>CARGO:</label>
                <input maxlength="20" name="CONYUGE_CARGO_TRABAJO" type="text" class="form-control" value="<?= $CONYUGE_CARGO_TRABAJO ?>">
            </div>
        </div>


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>UNIDAD:</label>
                <input maxlength="20" name="CONYUGE_UNIDAD_TRABAJO" type="text" class="form-control" value="<?= $CONYUGE_UNIDAD_TRABAJO ?>">
            </div>
        </div>


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>CÓNYUGE SUELDO:</label>
                <input maxlength="10" name="CONYUGE_SUELDO" type="text" class="form-control numerico" value="<?= $CONYUGE_SUELDO ?>">
            </div>

        </div>
    </div>
</fieldset>