<?php

$INMUEBLE = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE;
$INMUEBLE_VALOR = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE_VALOR;
$INMUEBLE_ESTADO = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE_ESTADO;
$CTA_CATASTRAL = !isset($deudor_dato) ? "" :  $deudor_dato->CTA_CATASTRAL;
$AUTO_MARCA = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_MARCA;
$AUTO_MODELO = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_MODELO;
$AUTO_CHAPA = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_CHAPA;
?>



<fieldset>
    <legend>POSESIONES</legend>
    <div class="row">


        <div class="col-12 col-md-4">


            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">INMUEBLE:</label>
                <input style="grid-column-start: 2;" oninput="validarSpecialChars(event)" maxlength="40" name="INMUEBLE" type="text" class="form-control" value='<?= $INMUEBLE ?>'>
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">VALOR INMUEBLE:</label>
                <input style="grid-column-start: 2;" maxlength="10" name="INMUEBLE_VALOR" type="text" class="form-control" value="<?= $INMUEBLE_VALOR ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">ESTADO INMUEBLE:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="INMUEBLE_ESTADO" type="text" class="form-control" value="<?= $INMUEBLE_ESTADO ?>">
            </div>

        </div>


        <div class="col-12 col-md-4">

            <div class="form-group" style="display: grid; grid-template-columns: 50% 50%; ">
                <label style="grid-column-start: 1;">CTA. CATASTRAL:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="INMUEBLE_ESTADO" type="text" class="form-control" value="<?= $CTA_CATASTRAL ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 50% 50%; ">
                <label style="grid-column-start: 1;">MARCA AUTOMÓVIL:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="AUTO_MARCA" type="text" class="form-control" value="<?= $AUTO_MARCA ?>">
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 50% 50%; ">
                <label style="grid-column-start: 1;">MODELO AUTOMÓVIL:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="AUTO_MODELO" type="text" class="form-control" value="<?= $AUTO_MODELO ?>">
            </div>


        </div>

        <div class="col-12 col-md-4">

            <div class="form-group" style="display: grid; grid-template-columns: 50% 50%; ">
                <label style="grid-column-start: 1;">CHAPA AUTOMÓVIL:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="AUTO_CHAPA" type="text" class="form-control" value="<?= $AUTO_CHAPA ?>">
            </div>

        </div>


    </div>

</fieldset>