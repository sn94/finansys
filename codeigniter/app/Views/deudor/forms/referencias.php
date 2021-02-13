<?php
$REFEREN_OBT = !isset($deudor_dato) ? "" :  $deudor_dato->REFEREN_OBT;
$OTRAS_REFEREN = !isset($deudor_dato) ? "" :  $deudor_dato->OTRAS_REFEREN;
$CTAS_ACTIVAS = !isset($deudor_dato) ? "" :  $deudor_dato->CTAS_ACTIVAS;
$CTAS_CANCELADAS = !isset($deudor_dato) ? "" :  $deudor_dato->CTAS_CANCELADAS;
$ANTECEDENTES = !isset($deudor_dato) ? "" :  $deudor_dato->ANTECEDENTES;
?>

<fieldset>
    <legend>REFERENCIAS</legend>

    <div class="row">

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>REFERENCIAS OBTENIDAS:</label>
                <textarea maxlength="200" name="REFEREN_OBT" type="text" class="form-control"  > <?= $REFEREN_OBT ?> </textarea>
            </div>
    </div>

    <div class="col-12 col-md-6">
    <div class="form-group">
                <label>OTRAS REFERENCIAS:</label>
                <textarea  maxlength="200" name="OTRAS_REFEREN" type="text" class="form-control" > <?= $OTRAS_REFEREN ?> </textarea>
            </div>
    </div>

    <div class="col-12 col-md-6">
    <div class="form-group">
                <label>CTAS. ACTIVAS:</label>
                <textarea maxlength="200" name="CTAS_ACTIVAS" type="text" class="form-control" > <?= $CTAS_ACTIVAS ?> </textarea>
            </div>
    </div>

    <div class="col-12 col-md-6">
    <div class="form-group">
                <label>CTAS. CANCELADAS:</label>
                <textarea maxlength="200" name="CTAS_CANCELADAS" type="text" class="form-control" > <?= $CTAS_CANCELADAS ?> </textarea>
            </div>
    </div>


        <div class="col-12 col-md-12">
        <div class="form-group">
                <label>ANTECEDENTES:</label>
                <textarea maxlength="200" name="ANTECEDENTES" type="text" class="form-control" > <?= $ANTECEDENTES ?> </textarea>
            </div>
        </div>
    </div>
</fieldset>