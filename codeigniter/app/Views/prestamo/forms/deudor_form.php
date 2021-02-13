<fieldset>

    <legend>DATOS DEL CLIENTE</legend>

    <input type="hidden" name="DEUDOR">
    <div class="row">
        <div class="col-12 col-md-2">
            <div class="form-group">
                <label>CI°/RUC TITULAR:</label>
                <input id="TITULAR_CI" readonly type="text" class="form-control" value="<?= !isset($prestamo_dato) ? "" :   $prestamo_dato->DEUDORCI ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>NOMBRE COMPLETO: </label>
                <input id="TITULAR_NOMBRES" readonly type="text" class="form-control" value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->DEUDORNOM ?>">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>DOMICILIO: </label>
                <input id="TITULAR_DOMICILIO" readonly type="text" class="form-control" value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->DEUDORNOM ?>">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>OCUPACIÓN: </label>
                <input id="TITULAR_OCUPACION" readonly type="text" class="form-control" value="<?= !isset($prestamo_dato) ? "" :  $prestamo_dato->DEUDORNOM ?>">
            </div>
        </div>
    </div>

</fieldset>