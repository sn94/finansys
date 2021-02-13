<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;
use App\Models\Porcentaje_model;

/**listas */
$tipo_moras = (new Porcentaje_model())->list_dropdown();
$empresas = (new Empresa_model())->list_dropdown();


$ANALISIS =  !isset($prestamo_dato->ANALISIS) ? "" :  $prestamo_dato->ANALISIS;
$INHIBIDO_SI =  !isset($prestamo_dato->INHIBIDO) ? "checked" : ($prestamo_dato->INHIBIDO == "SI" ? "checked" : "");
$INHIBIDO_NO =  !isset($prestamo_dato->INHIBIDO) ? "" : ($prestamo_dato->INHIBIDO == "NO" ? "checked" : "");
$MONTO_SOLICI =  !isset($prestamo_dato->MONTO_SOLICI) ? "0" : Utilidades::number_f($prestamo_dato->MONTO_SOLICI);
$MONTO_APROBADO =  !isset($prestamo_dato->MONTO_APROBADO) ? "0" : Utilidades::number_f($prestamo_dato->MONTO_APROBADO);
$MONTO_ENTREGADO =  !isset($prestamo_dato->MONTO_ENTREGADO) ? "0" : Utilidades::number_f($prestamo_dato->MONTO_ENTREGADO);
$CUOTAS =  !isset($prestamo_dato->CUOTAS) ? "" :  $prestamo_dato->CUOTAS;
$INFORCOMF =  !isset($prestamo_dato->INFORCOMF) ? "" :  $prestamo_dato->INFORCOMF;
$DICTAMEN =  !isset($prestamo_dato->DICTAMEN) ? "" :  $prestamo_dato->DICTAMEN;
$FECHA_INHIBICION =  !isset($prestamo_dato->FECHA_INHIBICION) ? "" :  $prestamo_dato->FECHA_INHIBICION;
$FECHA_APROBACION = !isset($prestamo_dato->FECHA_APROBACION) ? "" :  $prestamo_dato->FECHA_APROBACION;
$FECHA_SOLICI = !isset($prestamo_dato->FECHA_SOLICI) ? "" :  $prestamo_dato->FECHA_SOLICI;
$TIPO_CREDITO =  !isset($prestamo_dato->TIPO_CREDITO) ? "" :  $prestamo_dato->TIPO_CREDITO;
$TIPO_MORA =  !isset($prestamo_dato->TIPO_MORA) ? "" :  $prestamo_dato->TIPO_MORA;
$TIPOMORA1=  $TIPO_MORA == "1" ?  "checked" : "";
$TIPOMORA2=  $TIPO_MORA == "2" ?  "checked" : "";
$OFICIAL =  !isset($prestamo_dato->OFICIAL) ? "" :  $prestamo_dato->OFICIAL;
$EMPRESA =  !isset($prestamo_dato) ? "" :  $prestamo_dato->EMPRESA;
$OBSERVACION = !isset($prestamo_dato) ? "" :  $prestamo_dato->OBSERVACION;
$APROBADO = !isset($prestamo_dato) ? "" :  $prestamo_dato->APROBADOR;
?>
<fieldset>
    <legend>DETALLES DE LA SOLICITUD</legend>
    <div class="row">



        <?php
        $IDNRO =  !isset($prestamo_dato) ? "" :   $prestamo_dato->IDNRO;
        ?>
        <input type="hidden" name="IDNRO" value="<?= $IDNRO ?>">




        <?php
        $DEUDOR =  !isset($prestamo_dato) ? "" :   $prestamo_dato->DEUDOR;
        ?>
        <input type="hidden" name="DEUDOR" value="<?= $DEUDOR ?>">


        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>ANÁLISIS:</label>
                <input value="<?= $ANALISIS ?>" type="text" maxlength="50" name="ANALISIS" class="form-control">
            </div>
        </div>
        <div class="col-12 col-md-1">
            <div class="form-group">
                <label>INHIBIDO:</label>
                <p style="color: #525252;font-weight: 600;font-size: 12px;">

                    <input type="radio" name="INHIBIDO" id="genderS" value="SI" <?= $INHIBIDO_SI ?>> &nbsp;
                    SI

                    <input type="radio" name="INHIBIDO" id="genderN" value="NO" <?= $INHIBIDO_NO ?>>
                    NO &nbsp;
                </p>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>TIPO MORA:</label>
                <p style="color: #525252;font-weight: 600;font-size: 12px;">

                    <input type="radio" name="TIPO_MORA" id="genderS" value="1" <?= $TIPOMORA1 ?>> &nbsp;
                    TIPO 1

                    <input type="radio" name="TIPO_MORA" id="genderN" value="2" <?= $TIPOMORA2 ?>>
                    TIPO 2&nbsp;
                </p>
                <?php
                //  form_dropdown("TIPO_MORA", $tipo_moras,  $TIPO_MORA, ['class' => "form-control"]) ;
                ?>

            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>INFORCOMF :</label>
                <input maxlength="30" type="text" name="INFORCOMF" class="form-control" value="<?= $INFORCOMF ?>">
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>DICTAMEN :</label>
                <input maxlength="30" type="text" name="DICTAMEN" class="form-control" value="<?= $DICTAMEN ?>">
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>FEC. INHIBICIÓN. :</label>
                <input type="date" name="FECHA_INHIBICION" class="form-control" value="<?= $FECHA_INHIBICION ?>">
            </div>
        </div>

    </div>

    <div class="row">



        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>FEC. APROBACIÓN. :</label>
                <input type="date" name="FECHA_APROBACION" class="form-control" value="<?= $FECHA_APROBACION ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>TIPO CRÉDITO. :</label>
                <input maxlength="10" type="text" name="TIPO_CREDITO" class="form-control" value="<?= $TIPO_CREDITO ?>">
            </div>
        </div>
        <div class="col-12 col-md-6">

            <div class="form-group">
                <label>OFICIAL:</label>
                <input type="text" name="OFICIAL" class="form-control" maxlength="50" value="<?= $OFICIAL ?>">
            </div>
        </div>
    </div>



    <div class="row">



        <div class="col-12 col-md-4">

            <div class="form-group">
                <label>APROBADO:</label>
                <input class="form-control" value="<?= $APROBADO ?>" type="text" name="APROBADOR" maxlength="30">

            </div>
        </div>

        <div class="col-12 col-md-2">

            <div class="form-group">
                <label>SOLICITADO:</label>
                <input class="form-control text-right" value="<?= $MONTO_SOLICI ?>" type="text" name="MONTO_SOLICI" oninput="input_number_millares(event)">

            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>AUTORIZADO:</label>
                <input class="form-control text-right" value="<?= $MONTO_APROBADO ?>" type="text" name="MONTO_APROBADO" oninput="input_number_millares(event)">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>ENTREGADO:</label>
                <input class="form-control text-right" value="<?= $MONTO_ENTREGADO ?>" type="text" name="MONTO_ENTREGADO" oninput="input_number_millares(event)">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>CUOTAS:</label>
                <input class="form-control" value="<?= $CUOTAS ?>" type="text" name="CUOTAS" oninput="input_number_millares(event)">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>FEC. SOLICITUD :</label>
                <input type="date" name="FECHA_SOLICI" class="form-control" value="<?= $FECHA_SOLICI ?>">
            </div>
        </div>







    </div>
    <!--END ROW -->

    <div></div>
</fieldset>