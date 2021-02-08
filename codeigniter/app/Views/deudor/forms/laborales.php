<?php

$SUELDO = !isset($deudor_dato) ? "" :  $deudor_dato->SUELDO;
$INGRESOS1 = !isset($deudor_dato) ? "" :  $deudor_dato->INGRESOS1;
$INGRESOS2 = !isset($deudor_dato) ? "" :  $deudor_dato->INGRESOS2;
$INGRESOS3 = !isset($deudor_dato) ? "" :  $deudor_dato->INGRESOS3;
$DOMICILIO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->DOMICILIO_LABO;
$TELEFONO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->TELEFONO_LABO;
$HORARIO_LABO = !isset($deudor_dato) ? "" :  $deudor_dato->HORARIO_LABO;
?>



<fieldset>
    <legend>DATOS LABORALES</legend>
    <div class="row">


        <div class="col-12 col-md-4">


            <div class="form-group">
                <label>DOMICILIO LABORAL:</label>
                <input oninput="validarSpecialChars(event)" maxlength="50" name="DOMICILIO_LABO" type="text" class="form-control" value='<?= $DOMICILIO_LABO ?>'>
            </div>

            <div class="form-group">
                <label>TELÉFONO LABORAL:</label>
                <input maxlength="16" name="TELEFONO_LABO" type="text" class="form-control" value="<?= $TELEFONO_LABO ?>">
            </div>

            <div class="form-group">
                <label>HORARIO LABORAL:</label>
                <input maxlength="30" name="HORARIO_LABO" type="text" class="form-control" value="<?= $HORARIO_LABO ?>">
            </div>


        </div>


        <div class="col-12 col-md-4">
            <div class="form-group" style="display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">SUELDO:</label>
                <input style="grid-column-start: 2;" maxlength="10" name="SUELDO" type="text" class="form-control" value="<?= $SUELDO ?>">
            </div>
            <div class="form-group">
                <label>INGRESOS (1):</label>
                <input maxlength="40" name="INGRESOS1" type="text" class="form-control" value="<?= $INGRESOS1 ?>">
            </div>

            <div class="form-group">
                <label>INGRESOS (2):</label>
                <input maxlength="40" name="INGRESOS2" type="text" class="form-control" value="<?= $INGRESOS2 ?>">
            </div>
        </div>

        <div class="col-12 col-md-4">
         
            <div class="form-group">
                <label>INGRESOS (3):</label>
                <input maxlength="40" name="INGRESOS3" type="text" class="form-control" value="<?= $INGRESOS3 ?>">
            </div>

        </div>
    </div>

</fieldset>