<?php


$CEDU_ANVERSO = !isset($deudor_dato) ? "" :  $deudor_dato->CEDU_ANVERSO;
$CEDU_REVERSO = !isset($deudor_dato) ? "" :  $deudor_dato->CEDU_REVERSO;

?>

<fieldset>
    <legend>DOCUMENTO DE IDENTIDAD</legend>
    <div class="row">

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>CEDULA ANVERSO: </label>
                <input onchange="show_loaded_image(event)" name="CEDU_ANVERSO" type="file" class="form-control">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 " id="CEDU_ANVERSO">
                    <img style="width: 100%;" src="<?= $CEDU_ANVERSO ?>" alt="">

                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>CEDULA REVERSO: </label>
                <input onchange="show_loaded_image(event)" name="CEDU_REVERSO" type="file" class="form-control">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 " id="CEDU_REVERSO">
                    <img style="width: 100%;" src="<?= $CEDU_REVERSO ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</fieldset>