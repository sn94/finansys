<?php

$ALQUILER_IMPORTE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_IMPORTE;
$ALQUILER_PROPIE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_PROPIE;
$ALQUILER_TEL = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_TEL;
$ALQUILER_DESDE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_DESDE;
$TIPO_VIVIENDA =  !isset($deudor_dato) ? "" :  $deudor_dato->TIPO_VIVIENDA;
?>



<fieldset>
    <legend>VIDA </legend>
    <div class="row">

        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 25% 75%; ">
                <label style="grid-column-start: 1;">ARQUILER </label>
                <input style="grid-column-start: 2;" oninput="validarSpecialChars(event)" maxlength="50" name="ALQUILER_IMPORTE" type="text" class="form-control" value='<?= $ALQUILER_IMPORTE ?>'>
            </div>
        </div>


        <div class="col-12 col-md-4">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">TELÉFONO (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_TEL" type="text" class="form-control" value="<?= $ALQUILER_TEL ?>">
            </div>
        </div>

        <div class="col-12 col-md-5">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">PROPIETARIO (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_PROPIE" type="text" class="form-control" value="<?= $ALQUILER_PROPIE ?>">
            </div>
        </div>


        <div class="col-12 col-md-5">
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">FECHA DESDE (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_DESDE" type="text" class="form-control" value="<?= $ALQUILER_DESDE ?>">
            </div>
        </div>

      

        <div class="col-12 col-md-4">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">TIPO VIVIENDA:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="TIPO_VIVIENDA" type="text" class="form-control" value="<?= $TIPO_VIVIENDA ?>">
            </div>
        </div>




    </div>

</fieldset>