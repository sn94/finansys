<?php

$ALQUILER_IMPORTE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_IMPORTE;
$ALQUILER_PROPIE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_PROPIE;
$ALQUILER_TEL = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_TEL;
$ALQUILER_DESDE = !isset($deudor_dato) ? "" :  $deudor_dato->ALQUILER_DESDE;

?>



<fieldset>
    <legend>OTROS </legend>
    <div class="row">


        <div class="col-12 col-md-4">


            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">ARQUILER (IMPORTE):</label>
                <input style="grid-column-start: 2;" oninput="validarSpecialChars(event)" maxlength="50" name="ALQUILER_IMPORTE" type="text" class="form-control" value='<?= $ALQUILER_IMPORTE ?>'>
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">PROPIETARIO (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_PROPIE" type="text" class="form-control" value="<?= $ALQUILER_PROPIE ?>">
            </div>


        </div>

        <div class="col-12 col-md-4">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">TELÉFONO (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_TEL" type="text" class="form-control" value="<?= $ALQUILER_TEL ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">FECHA DESDE (ALQUILER):</label>
                <input style="grid-column-start: 2;" maxlength="16" name="ALQUILER_DESDE" type="text" class="form-control" value="<?= $ALQUILER_DESDE ?>">
            </div>
        </div>



    </div>

</fieldset>