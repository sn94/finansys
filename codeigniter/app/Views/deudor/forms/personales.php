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
$CEDULA_CONYU =  !isset($deudor_dato) ? "" :  $deudor_dato->CEDULA_CONYU;
$CONYUGE = !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE;
$CONYUGE_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_TELEF;
$CONYUGE_SUELDO =  !isset($deudor_dato) ? "" :  $deudor_dato->CONYUGE_SUELDO;
$CEDU_ANVERSO = !isset($deudor_dato) ? "" :  $deudor_dato->CEDU_ANVERSO;
$CEDU_REVERSO = !isset($deudor_dato) ? "" :  $deudor_dato->CEDU_REVERSO;
$EMAIL = !isset($deudor_dato) ? "" :  $deudor_dato->EMAIL;
$ESTADO_CIVIL = !isset($deudor_dato) ? "" :  $deudor_dato->ESTADO_CIVIL;
$FAMILIAR1 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR1;
$FAMILIAR2 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR2;
$FAMILIAR3 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR3;
$FAMILIAR1_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR1_TELEF;
$FAMILIAR2_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR2_TELEF;
$FAMILIAR3_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR3_TELEF;
?>



<fieldset>
    <legend>DATOS PERSONALES</legend>


    <div class="row">

        <div class="col-12 col-md-4">
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%;">
                <label style="grid-column-start: 1;">CEDULA:</label>
                <input style="grid-column-start: 2;" maxlength="8" oninput="input_number(event)" name="CEDULA" type="text" class="form-control" value="<?= $CEDULA ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%;">
                <label style="grid-column-start: 1;">RUC:</label>
                <input style="grid-column-start: 2;" maxlength="13" oninput="input_number(event)" name="RUC" type="text" class="form-control" value="<?= $RUC ?>">
            </div>

            <div class="form-group">
                <label>NOMBRES: </label>
                <input maxlength="50" name="NOMBRES" type="text" class="form-control" value="<?= $NOMBRES ?>">
            </div>

            <div class="form-group">
                <label>APELLIDOS:</label>
                <input maxlength="50" name="APELLIDOS" type="text" class="form-control" value="<?= $APELLIDOS ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">FECHA DE NAC.:</label>
                <input style="grid-column-start: 2;" name="FECHA_NAC" type="date" class="form-control" value="<?= $FECHA_NAC ?>">
            </div>

            <div class="form-group">
                <label>SEXO:</label>
                <p style="color: #525252;font-weight: 600;">

                    <input type="radio" name="SEXO" id="genderM" value="" <?= !isset($deudor_dato) ? "checked" : ($deudor_dato->SEXO == "" ? "checked" : "") ?>> &nbsp;
                    NO DEFINE

                    <input type="radio" name="SEXO" id="genderM" value="M" <?= !isset($deudor_dato) ? "" : ($deudor_dato->SEXO == "M" ? "checked" : "") ?>> MASCULINO &nbsp;

                    <input type="radio" name="SEXO" id="genderF" value="F" <?= !isset($deudor_dato) ? "" : ($deudor_dato->SEXO == "F" ? "checked" : "") ?>> FEMENINO
                </p>
            </div>


        </div>

        <div class="col-12 col-md-4">

            <div class="form-group">
                <label>DOMICILIO: </label>
                <input oninput="validarSpecialChars(event)" maxlength="60" name="DOMICILIO" type="text" class="form-control" value='<?= $DOMICILIO ?>'>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">BARRIO: </label>
                <input style="grid-column-start: 2;" oninput="validarSpecialChars(event)" maxlength="40" name="BARRIO" type="text" class="form-control" value='<?= $BARRIO ?>'>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">TELÉFONO </label>
                <input style="grid-column-start: 2;" maxlength="16" name="TELEFONO" type="text" class="form-control" value="<?= $TELEFONO ?>">
            </div>

            <div class="form-group">
                <label>EMAIL </label>
                <input maxlength="80" name="EMAIL" type="text" class="form-control" value="<?= $EMAIL ?>">
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">CELULAR</label>
                <input style="grid-column-start: 2;" maxlength="16" name="CELULAR" type="text" class="form-control" value="<?= $CELULAR ?>">
            </div>


            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">CIUDAD:</label>
                <input style="grid-column-start: 2;" type="text" maxlength="50" name="CIUDAD" class="form-control col-md-10 ciudad" autocomplete="off">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">ESTADO CIVIL:</label>
                <select style="grid-column-start: 2;" name="ESTADO_CIVIL" class="form-control">

                    <?php
                    $estado_civil = ["S" => "SOLTERO/A",  "C" => "CASADO/A", "V" =>  "VIUDO/A", "" =>  "INDEFINIDA"];
                    foreach ($estado_civil as $key => $valu) : ?>
                        <option value="<?= $key ?>"><?= $valu ?> </option>
                    <?php endforeach; ?>
                </select>

            </div>
        </div>


        <div class="col-12 col-md-4">

            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">CI° CÓNYUGE:</label>
                <input style="grid-column-start: 2;" oninput="input_number(event)" maxlength="8" name="CEDULA_CONYU" type="text" class="form-control" value="<?= $CEDULA_CONYU ?>">
            </div>

            <div class="form-group">
                <label>NOMBRE DE CÓNYUGE:</label>
                <input maxlength="50" name="CONYUGE" type="text" class="form-control" value="<?= $CONYUGE ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">CÓNYUGE TELÉF.:</label>
                <input style="grid-column-start: 2;" maxlength="20" name="CONYUGE_TELEF" type="text" class="form-control" value="<?= $CONYUGE_TELEF ?>">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">CÓNYUGE SUELDO:</label>
                <input style="grid-column-start: 2;" maxlength="10" name="CONYUGE_SUELDO" type="text" class="form-control" value="<?= $CONYUGE_SUELDO ?>">
            </div>

            <div class="form-group">
                <label>CEDULA ANVERSO: </label>
                <input onchange="show_loaded_image(event)" name="CEDU_ANVERSO" type="file" class="form-control">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 " id="CEDU_ANVERSO">
                    <img style="width: 100%;" src="<?= $CEDU_ANVERSO ?>" alt="">

                </div>
            </div>




            <div class="form-group">
                <label>CEDULA REVERSO: </label>
                <input onchange="show_loaded_image(event)" name="CEDU_REVERSO" type="file" class="form-control">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 " id="CEDU_REVERSO">
                    <img style="width: 100%;" src="<?= $CEDU_REVERSO ?>" alt="">
                </div>
            </div>



        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>FAMILIAR(1):</label>
                <input maxlength="20" name="FAMILIAR1" type="text" class="form-control" value="<?= $FAMILIAR1 ?>">
            </div>

            <div class="form-group">
                <label>FAMILIAR TELÉF.:</label>
                <input maxlength="20" name="FAMILIAR1_TELEF" type="text" class="form-control" value="<?= $FAMILIAR1_TELEF ?>">
            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>FAMILIAR(2):</label>
                <input maxlength="20" name="FAMILIAR2" type="text" class="form-control" value="<?= $FAMILIAR2 ?>">
            </div>

            <div class="form-group">
                <label>FAMILIAR(2) TELÉF.:</label>
                <input maxlength="20" name="FAMILIAR2_TELEF" type="text" class="form-control" value="<?= $FAMILIAR2_TELEF ?>">
            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>FAMILIAR(3):</label>
                <input maxlength="20" name="FAMILIAR3" type="text" class="form-control" value="<?= $FAMILIAR3 ?>">
            </div>

            <div class="form-group">
                <label>FAMILIAR(3) TELÉF.:</label>
                <input maxlength="20" name="FAMILIAR3_TELEF" type="text" class="form-control" value="<?= $FAMILIAR3_TELEF ?>">
            </div>

        </div>


    </div>

</fieldset>