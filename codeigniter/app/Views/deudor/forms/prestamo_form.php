<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;
use App\Models\Porcentaje_model;

/**listas */
$tipo_moras = (new Porcentaje_model())->list_dropdown();
$empresas = (new Empresa_model())->list_dropdown();


$ANALISIS =  !isset($deudor_dato->ANALISIS) ? "" :  $deudor_dato->ANALISIS;
$INHIBIDO_SI =  !isset($deudor_dato->INHIBIDO) ? "checked" : ($deudor_dato->INHIBIDO == "SI" ? "checked" : "");
$INHIBIDO_NO =  !isset($deudor_dato->INHIBIDO) ? "" : ($deudor_dato->INHIBIDO == "NO" ? "checked" : "");
$MONTO_SOLICI =  !isset($deudor_dato->MONTO_SOLICI) ? "0" : Utilidades::number_f($deudor_dato->MONTO_SOLICI);
$MONTO_APROBADO =  !isset($deudor_dato->MONTO_APROBADO) ? "0" : Utilidades::number_f($deudor_dato->MONTO_APROBADO);
$MONTO_ENTREGADO =  !isset($deudor_dato->MONTO_ENTREGADO) ? "0" : Utilidades::number_f($deudor_dato->MONTO_ENTREGADO);
$CUOTAS =  !isset($deudor_dato->CUOTAS) ? "" :  $deudor_dato->CUOTAS;
$INFORCOMF =  !isset($deudor_dato->INFORCOMF) ? "" :  $deudor_dato->INFORCOMF;
$DICTAMEN =  !isset($deudor_dato->DICTAMEN) ? "" :  $deudor_dato->DICTAMEN;
$FECHA_INHIBICION =  !isset($deudor_dato->FECHA_INHIBICION) ? "" :  $deudor_dato->FECHA_INHIBICION;
$FECHA_APROBACION = !isset($deudor_dato->FECHA_APROBACION) ? "" :  $deudor_dato->FECHA_APROBACION;
$FECHA_SOLICI = !isset($deudor_dato->FECHA_SOLICI) ? "" :  $deudor_dato->FECHA_SOLICI;
$TIPO_CREDITO =  !isset($deudor_dato->TIPO_CREDITO) ? "" :  $deudor_dato->TIPO_CREDITO;

$TIPO_MORA =  !isset($deudor_dato->TIPO_MORA) ? "" :  $deudor_dato->TIPO_MORA;
$TIPOMORA1 =  $TIPO_MORA == "1" ?  "checked" : "";
$TIPOMORA2 =  $TIPO_MORA == "2" ?  "checked" : "";
$OFICIAL =  !isset($deudor_dato->OFICIAL) ? "" :  $deudor_dato->OFICIAL;
$EMPRESA =  !isset($deudor_dato) ? "" :  $deudor_dato->EMPRESA;
$APROBADO = !isset($deudor_dato) ? "" :  $deudor_dato->APROBADOR;
?>
<fieldset>
    <legend>DETALLES DE LA SOLICITUD</legend>
    <div class="row">


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
                <?php
                $tipos_credito = ['1' => 'S/firma', '2' => 'c/Garante'];
                echo form_dropdown("TIPO_CREDITO", $tipos_credito,  $TIPO_CREDITO, ['class' => "form-control"]);
                ?>

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
                <input class="form-control text-right numerico" value="<?= $MONTO_SOLICI ?>" type="text" name="MONTO_SOLICI" oninput="input_number_millares(event)">

            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>AUTORIZADO:</label>
                <input class="form-control text-right numerico" value="<?= $MONTO_APROBADO ?>" type="text" name="MONTO_APROBADO" oninput="input_number_millares(event)">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>ENTREGADO:</label>
                <input class="form-control text-right numerico" value="<?= $MONTO_ENTREGADO ?>" type="text" name="MONTO_ENTREGADO" oninput="input_number_millares(event)">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>CUOTAS:</label>
                <input class="form-control numerico" value="<?= $CUOTAS ?>" type="text" name="CUOTAS" oninput="input_number_millares(event)">
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