<?php

$SUELDO = !isset($deudor_dato) ? "" :  $deudor_dato->SUELDO;
$OTROS_INGRESOS = !isset($deudor_dato) ? "" :  $deudor_dato->OTROS_INGRESOS;
$INGRESOS1 = !isset($deudor_dato) ? "" :  $deudor_dato->INGRESOS1;
$INGRESOS2 = !isset($deudor_dato) ? "" :  $deudor_dato->INGRESOS2;
$INGRESO_LIQUIDO = !isset($deudor_dato) ? "" : ($deudor_dato->INGRESOS1 +  $deudor_dato->INGRESOS2 +  $deudor_dato->SUELDO);

$HORARIO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->HORARIO_LABO;
$TIPO_INSTI_TRABAJO =  !isset($deudor_dato) ? "" :  $deudor_dato->TIPO_INSTI_TRABAJO; //OCUPACION

$TRABAJO1 =   !isset($deudor_dato) ? "" :  $deudor_dato->TRABAJO1;
$DOMICILIO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->DOMICILIO_LABO;
$TELEFONO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->TELEFONO_LABO;
$ANTIGUEDAD_ANIOS =  !isset($deudor_dato) ? "" :  $deudor_dato->ANTIGUEDAD_ANIOS;
$ANTIGUEDAD_MESES =  !isset($deudor_dato) ? "" :  $deudor_dato->ANTIGUEDAD_MESES;
$DEPARTAMENTO =  !isset($deudor_dato) ? "" :  $deudor_dato->DEPARTAMENTO;
$CARGO =  !isset($deudor_dato) ? "" :  $deudor_dato->CARGO;

$TRABAJO2 =   !isset($deudor_dato) ? "" :  $deudor_dato->TRABAJO2;
$TRABAJO2_DIR = !isset($deudor_dato) ? "" :  $deudor_dato->TRABAJO2_DIR;
$TRABAJO2_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->TRABAJO2_TELEF;

?>



<fieldset>
    <legend>DATOS LABORALES</legend>
    <div class="row">

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>OCUPACIÓN:</label>
                <?= form_dropdown("TIPO_INSTI_TRABAJO", ['PRIVADO' => 'PRIVADO', 'PUBLICO' => 'PUBLICO'],  $TIPO_INSTI_TRABAJO, ['class' => "select2_single form-control"]) ?>
            </div>
        </div>

        <div class="col-12 col-md-4"  >

            <div class="form-group">
                <label>ANTIGUEDAD:</label>
                <div style="display: grid;grid-template-columns: 20% 30% 20% 30%;">
                    <label style="grid-column-start: 1;">Años</label>
                    <input style="grid-column-start: 2;" maxlength="3" name="ANTIGUEDAD_ANIOS" type="text" class="form-control numerico" value="<?= $ANTIGUEDAD_ANIOS ?>">

                    <label style="grid-column-start: 3;"> Meses</label>
                    <input style="grid-column-start: 4;" maxlength="3" name="ANTIGUEDAD_MESES" type="text" class="form-control numerico" value="<?= $ANTIGUEDAD_MESES ?>">
                </div>
            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>HORARIO LABORAL:</label>
                <input maxlength="30" name="HORARIO_LABO" type="text" class="form-control" value="<?= $HORARIO_LABO ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TRABAJO 1:</label>
                <input maxlength="30" name="TRABAJO1" type="text" class="form-control" value="<?= $TRABAJO1 ?>">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>TELÉFONO LABORAL:</label>
                <input maxlength="16" name="TELEFONO_LABO" type="text" class="form-control" value="<?= $TELEFONO_LABO ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>DOMICILIO LABORAL:</label>
                <input oninput="validarSpecialChars(event)" maxlength="50" name="DOMICILIO_LABO" type="text" class="form-control" value='<?= $DOMICILIO_LABO ?>'>
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>CARGO:</label>
                <input maxlength="30" name="CARGO" type="text" class="form-control" value="<?= $CARGO ?>">
            </div>
        </div>


        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>UNIDAD O DEP.:</label>
                <input maxlength="30" name="DEPARTAMENTO" type="text" class="form-control" value="<?= $DEPARTAMENTO ?>">
            </div>

        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TRABAJO 2:</label>
                <input maxlength="30" name="TRABAJO2" type="text" class="form-control" value="<?= $TRABAJO2 ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TELÉFONO:</label>
                <input maxlength="30" name="TRABAJO2_TELEF" type="text" class="form-control" value="<?= $TRABAJO2_TELEF ?>">
            </div>
        </div>


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>DIRECCIÓN:</label>
                <input maxlength="30" name="TRABAJO2_DIR" type="text" class="form-control" value="<?= $TRABAJO2_DIR ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
        </div>


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>OTROS INGRESOS:</label>
                <input maxlength="30" name="OTROS_INGRESOS" type="text" class="form-control " value="<?= $OTROS_INGRESOS ?>">
            </div>
        </div>


        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>SUELDO:</label>
                <input oninput="input_number_millares(event)" maxlength="10" name="SUELDO" type="text" class="form-control numerico" value="<?= $SUELDO ?>">
            </div>

        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>INGRESOS (1) +:</label>
                <input oninput="input_number_millares(event)" maxlength="10" name="INGRESOS1" type="text" class="form-control numerico" value="<?= $INGRESOS1 ?>">
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>INGRESOS (2) +:</label>
                <input oninput="input_number_millares(event)" maxlength="" name="INGRESOS2" type="text" class="form-control numerico" value="<?= $INGRESOS2 ?>">
            </div>
        </div>

        <div class="col-12 col-md-2">

            <div class="form-group">
                <label>INGRESO LÍQUIDO:</label>
                <input readonly maxlength="10" name="INGRESO_LIQUIDO" type="text" class="form-control" value="<?= $INGRESO_LIQUIDO ?>">
            </div>

        </div>
    </div>

</fieldset>