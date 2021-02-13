<?php

$INMUEBLE = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE;
$INMUEBLE_VALOR = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE_VALOR;
$INMUEBLE_ESCRITURA = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE_ESCRITURA;
$INMUEBLE_ACLARACION = !isset($deudor_dato) ? "" :  $deudor_dato->INMUEBLE_ACLARACION;
$NRO_FINCA = !isset($deudor_dato) ? "" :  $deudor_dato->NRO_FINCA;
$CTA_CATASTRAL = !isset($deudor_dato) ? "" :  $deudor_dato->CTA_CATASTRAL;
$AUTO_MARCA = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_MARCA;
$AUTO_MODELO = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_MODELO;
$AUTO_CHAPA = !isset($deudor_dato) ? "" :  $deudor_dato->AUTO_CHAPA;
?>



<fieldset>
    <legend>POSESIONES</legend>
    <div class="row">


        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">UBIC. INMUEBLE:</label>
                <input style="grid-column-start: 2;" oninput="validarSpecialChars(event)" maxlength="40" name="INMUEBLE" type="text" class="form-control" value='<?= $INMUEBLE ?>'>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">VALOR APROX.:</label>
                <input style="grid-column-start: 2;" maxlength="10" name="INMUEBLE_VALOR" type="text" class="form-control numerico" value="<?= $INMUEBLE_VALOR ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">ESCRITURA:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="INMUEBLE_ESCRITURA" type="text" class="form-control" value="<?= $INMUEBLE_ESCRITURA ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">ACLARACIÓN:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="INMUEBLE_ACLARACION" type="text" class="form-control" value="<?= $INMUEBLE_ACLARACION ?>">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group"  >
                <label  >CTA. CATASTRAL:</label>
                <input   maxlength="20" name="CTA_CATASTRAL" type="text" class="form-control" value="<?= $CTA_CATASTRAL ?>">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group"  >
                <label  >N° FINCA:</label>
                <input  maxlength="20" name="NRO_FINCA" type="text" class="form-control" value="<?= $NRO_FINCA ?>">
            </div>
        </div>


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>MARCA AUTOMÓVIL:</label>
                <input maxlength="20" name="AUTO_MARCA" type="text" class="form-control" value="<?= $AUTO_MARCA ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group" >
                <label >MODELO AUTOMÓVIL:</label>
                <input  maxlength="20" name="AUTO_MODELO" type="text" class="form-control" value="<?= $AUTO_MODELO ?>">
            </div>


        </div>

        <div class="col-12 col-md-2">

            <div class="form-group"  >
                <label  >CHAPA AUTOMÓVIL:</label>
                <input maxlength="20" name="AUTO_CHAPA" type="text" class="form-control" value="<?= $AUTO_CHAPA ?>">
            </div>

        </div>


    </div>

</fieldset>