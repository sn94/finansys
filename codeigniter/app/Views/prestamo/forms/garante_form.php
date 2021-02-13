

<fieldset>

<legend> GARANTES</legend>
<div class="row">
    <div class="col-12 col-md-2">
        <div class="form-group">
            <label>CI° GARANTE (1):</label>
            <input maxlength="10"  id="GARANTE1_CED" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTECI) ? "" :   $prestamo_dato->GARANTECI ?>">
        </div>
    </div>

    <div class="col-12 col-md-5">
        <div class="form-group">
            <label>GARANTE (1) NOMBRE COMPLETO: </label>
            <input maxlength="100"   id="GARANTE1_NOM" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
    <div class="col-12 col-md-2">
        <div class="form-group">
            <label>GARANTE (1) TELÉFONO: </label>
            <input  maxlength="20" id="GARANTE1_TEL" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>GARANTE (1) OCUPACIÓN: </label>
            <input  maxlength="30" id="GARANTE1_OCUPACION" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-2">
        <div class="form-group">
            <label>CI° GARANTE (2):</label>
            <input maxlength="10"  id="GARANTE2_CED" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTECI) ? "" :   $prestamo_dato->GARANTECI ?>">
        </div>
    </div>

    <div class="col-12 col-md-5">
        <div class="form-group">
            <label>GARANTE (2) NOMBRE COMPLETO: </label>
            <input maxlength="100"  id="GARANTE2_NOM" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
    <div class="col-12 col-md-2">
        <div class="form-group">
            <label>GARANTE (2) TELÉFONO: </label>
            <input  maxlength="20" id="GARANTE2_TEL" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>GARANTE (2) OCUPACIÓN: </label>
            <input maxlength="30" id="GARANTE2_OCUPACION" type="text" class="form-control" value="<?= !isset($prestamo_dato->GARANTENOM) ? "" :  $prestamo_dato->GARANTENOM ?>">
        </div>
    </div>
</div>

</fieldset>

