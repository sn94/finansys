<?php
$FAMILIAR1 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR1;
$FAMILIAR2 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR2;
$FAMILIAR3 = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR3;
$FAMILIAR1_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR1_TELEF;
$FAMILIAR2_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR2_TELEF;
$FAMILIAR3_TELEF = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR3_TELEF;
$FAMILIAR1_EMPLEO = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR1_EMPLEO;
$FAMILIAR2_EMPLEO = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR2_EMPLEO;
$FAMILIAR3_EMPLEO = !isset($deudor_dato) ? "" :  $deudor_dato->FAMILIAR3_EMPLEO;
?>
<fieldset>
    <legend>FAMILIA</legend>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>FAMILIAR(1):</label>
                <input maxlength="20" name="FAMILIAR1" type="text" class="form-control" value="<?= $FAMILIAR1 ?>">
            </div>

            <div class="form-group">
                <label>FAMILIAR (1) TELÉF.:</label>
                <input maxlength="20" name="FAMILIAR1_TELEF" type="text" class="form-control" value="<?= $FAMILIAR1_TELEF ?>">
            </div>

            <div class="form-group">
                <label>FAMILIAR(1) EMPLEO.:</label>
                <input maxlength="20" name="FAMILIAR1_EMPLEO" type="text" class="form-control" value="<?= $FAMILIAR1_EMPLEO ?>">
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

            <div class="form-group">
                <label>FAMILIAR(2) EMPLEO.:</label>
                <input maxlength="20" name="FAMILIAR2_EMPLEO" type="text" class="form-control" value="<?= $FAMILIAR2_EMPLEO ?>">
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

            <div class="form-group">
                <label>FAMILIAR(3) EMPLEO.:</label>
                <input maxlength="20" name="FAMILIAR3_EMPLEO" type="text" class="form-control" value="<?= $FAMILIAR3_EMPLEO ?>">
            </div>

        </div>


    </div>
</fieldset>