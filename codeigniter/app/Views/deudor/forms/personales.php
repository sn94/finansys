<?php

$CEDULA =  !isset($deudor_dato) ? "" :   $deudor_dato->CEDULA;
$RUC =  !isset($deudor_dato) ? "" :   $deudor_dato->RUC;
$NOMBRES = !isset($deudor_dato) ? "" :  $deudor_dato->NOMBRES;
$APELLIDOS = !isset($deudor_dato) ? "" :  $deudor_dato->APELLIDOS;
$BARRIO = !isset($deudor_dato) ? "" :  $deudor_dato->DOMICILIO;
$FECHA_NAC = !isset($deudor_dato) ? "" :  $deudor_dato->FECHA_NAC;
$DOMICILIO =  !isset($deudor_dato) ? "" :  $deudor_dato->DOMICILIO;
$TELEFONO = !isset($deudor_dato) ? "" :  $deudor_dato->TELEFONO;
$CELULAR = !isset($deudor_dato) ? "" :  $deudor_dato->CELULAR;


$EMAIL = !isset($deudor_dato) ? "" :  $deudor_dato->EMAIL;
$ESTADO_CIVIL = !isset($deudor_dato) ? "" :  $deudor_dato->ESTADO_CIVIL;

?>



<fieldset>
    <legend>DATOS PERSONALES</legend>

 

    <div class="row m-0">

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>NOMBRES: </label>
                <input maxlength="50" name="NOMBRES" type="text" class="form-control" value="<?= $NOMBRES ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>APELLIDOS:</label>
                <input maxlength="50" name="APELLIDOS" type="text" class="form-control" value="<?= $APELLIDOS ?>">
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>DOMICILIO: </label>
                <input oninput="validarSpecialChars(event)" maxlength="60" name="DOMICILIO" type="text" class="form-control" value='<?= $DOMICILIO ?>'>
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>BARRIO: </label>
                <input oninput="validarSpecialChars(event)" maxlength="40" name="BARRIO" type="text" class="form-control" value='<?= $BARRIO ?>'>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">LOCALIDAD:</label>
                <input style="grid-column-start: 2;" type="text" maxlength="50" name="CIUDAD" class="form-control col-md-10 ciudad" autocomplete="off">
            </div>

        </div>




        <div class="col-12 col-md-3">
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">TELÉFONO </label>
                <input style="grid-column-start: 2;" maxlength="16" name="TELEFONO" type="text" class="form-control" value="<?= $TELEFONO ?>">
            </div>
        </div>

        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 30% 70%; ">

            <label style="grid-column-start: 1;">CELULAR</label>
            <input style="grid-column-start: 2;" maxlength="16" name="CELULAR" type="text" class="form-control" value="<?= $CELULAR ?>">

        </div>


        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 30% 70%; ">
            <label style="grid-column-start: 1;">CEDULA:</label>
            <input style="grid-column-start: 2;" maxlength="8" oninput="input_number(event)" name="CEDULA" type="text" class="form-control numerico" value="<?= $CEDULA ?>">


        </div>



        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 20% 80%; ">

            <label style="grid-column-start: 1;">EMAIL </label>
            <input style="grid-column-start: 2;" maxlength="80" name="EMAIL" type="text" class="form-control" value="<?= $EMAIL ?>">

        </div>



        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 20% 80%; ">

            <label>SEXO:</label>
            <p style="color: #525252;font-weight: 600; font-size: 12px;">

                <input type="radio" name="SEXO" id="genderM" value="M" <?= !isset($deudor_dato) ? "" : ($deudor_dato->SEXO == "M" ? "checked" : "") ?>> MASCULINO &nbsp;

                <input type="radio" name="SEXO" id="genderF" value="F" <?= !isset($deudor_dato) ? "" : ($deudor_dato->SEXO == "F" ? "checked" : "") ?>> FEMENINO
            </p>
        </div>


        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 35% 65%; ">
            <label style="grid-column-start: 1;">ESTADO CIVIL:</label>
            <select style="grid-column-start: 2;" name="ESTADO_CIVIL" class="form-control">

                <?php
                $estado_civil = ["S" => "SOLTERO/A",  "C" => "CASADO/A", "V" =>  "VIUDO/A", "" =>  "INDEFINIDA"];
                foreach ($estado_civil as $key => $valu) : ?>
                    <option value="<?= $key ?>"><?= $valu ?> </option>
                <?php endforeach; ?>
            </select>
        </div>



        <div class="col-12 col-md-3" style="display: grid; grid-template-columns: 35% 65%; ">
            <label style="grid-column-start: 1;">FECHA DE NAC.:</label>
            <input style="grid-column-start: 2;" name="FECHA_NAC" type="date" class="form-control" value="<?= $FECHA_NAC ?>">
        </div>







    </div>





</fieldset>