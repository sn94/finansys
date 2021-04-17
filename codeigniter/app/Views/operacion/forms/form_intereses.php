<?php

//Parametros

use App\Models\Parametros_model;
use App\Models\Productos_finan_model;

/**Producto financiero */
$prod_fina=   (new Productos_finan_model())->select(
    "productos_finan.*,
format(MORA_PORCE,  4,  'de_DE' ) AS MORA_PORCE  , FORMAT(PUNITORIO_PORCE, 4, 'de_DE' ) as PUNITORIO_PORCE,
format(GAST_ADM_PORCE,  4,  'de_DE' ) AS GAST_ADM_PORCE ,
format(INTERES_PORCE,  4,  'de_DE' )  AS INTERES_PORCE
"
)->first();

/**Parametros */
$params= (new Parametros_model())->select(
    "parametros.*,FORMAT( parametros.BCP_INTERES,4, 'de_DE') AS BCP_INTERES,
FORMAT( parametros.IVA,4, 'de_DE') AS INTERES_IVA_PORCE")->first();


$INTERES_IVA_PORCE =  (isset($OPERACION) ? ($OPERACION->INTERES_IVA_PORCE == "" ? $params->INTERES_IVA_PORCE  :  $OPERACION->INTERES_IVA_PORCE) :  $params->INTERES_IVA_PORCE);
$INTERES_PORCE =    (isset($OPERACION) ?  $OPERACION->INTERES_PORCE :   $prod_fina->INTERES_PORCE);
$TOTAL_INTERESES =    (isset($OPERACION) ?  $OPERACION->TOTAL_INTERESES :    0);
$TOTAL_INTERESES_IVA =    (isset($OPERACION) ?  $OPERACION->TOTAL_INTERESES_IVA :    0);

?>
<div class="form-group mr-1" style="grid-column-start: 1;display: grid; grid-template-columns: 40% 60%;">
    <label style="grid-column-start: 1;">% INTERÉS: </label>
    <input readonly style="grid-column-start: 2;" value="<?= $INTERES_PORCE ?>" id="INTERES_PORCE" name="INTERES_PORCE" type="text" class="form-control decimal">
</div>
<div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
    <label style="grid-column-start: 1;">INTERESES: </label>
    <input readonly style="grid-column-start: 2;" name="TOTAL_INTERESES" value="<?= $TOTAL_INTERESES ?>" id="INTERESES" type="text" class="form-control entero">
</div>
<div style="display: grid; grid-template-columns: 40% 60%; ">
    <div class="form-group" style="grid-column-start: 1;display: grid; grid-template-columns: 40% 60%; ">
        <label style="grid-column-start: 1;">%I.V.A: </label>
        <input readonly style="grid-column-start: 2;" id="INTERES_IVA_PORCE" value="<?= $INTERES_IVA_PORCE ?>" name="INTERES_IVA_PORCE" type="text" class="form-control  entero">
    </div>
    <div class="form-group" style="grid-column-start: 2;display: grid; grid-template-columns: 30% 70%; ">
        <label style="grid-column-start: 1;">&nbsp; I.V.A: </label>
        <input readonly style="grid-column-start: 2;" value="<?= $TOTAL_INTERESES_IVA ?>" name="TOTAL_INTERESES_IVA" id="INTERES_IVA" type="text" class="form-control entero">
    </div>
</div>