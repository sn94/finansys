<?php 

//Parametros

use App\Controllers\Parametros;
use App\Models\Parametros_model;

$paramtros=   (new Parametros_model())->select("parametros.*,FORMAT( parametros.BCP_INTERES/12,4, 'de_DE') AS PORCEN_INTERES,
		FORMAT( parametros.IVA,4, 'de_DE') AS IVA
		")
		->first() ;

$PORCEN_IVA_INTERES =  (isset($OPERACION) ? ( $OPERACION->PORCEN_IVA_INTERES =="" ? $paramtros->IVA  :  $OPERACION->PORCEN_IVA_INTERES) :  $paramtros->IVA);
$PORCEN_INTERES =    (isset($OPERACION) ?  $OPERACION->PORCEN_INTERES :   $paramtros->PORCEN_INTERES);
$TOTAL_INTERESES =    (isset($OPERACION) ?  $OPERACION->TOTAL_INTERESES :    0);
$TOTAL_INTERESES_IVA=    (isset($OPERACION) ?  $OPERACION->TOTAL_INTERESES_IVA :    0);
?>
<div class="form-group mr-1" style="grid-column-start: 1;display: grid; grid-template-columns: 40% 60%;">
            <label style="grid-column-start: 1;">% INTERÉS: </label>
            <input readonly style="grid-column-start: 2;" value="<?= $PORCEN_INTERES ?>" id="PORCEN_INTERES" name="PORCEN_INTERES" type="text" class="form-control decimal">
        </div>
        <div class="form-group" style="display: grid; grid-template-columns: 40% 60%; ">
            <label style="grid-column-start: 1;">INTERESES: </label>
            <input readonly style="grid-column-start: 2;" name="TOTAL_INTERESES" value="<?=$TOTAL_INTERESES?>" id="INTERESES" type="text" class="form-control entero">
        </div>
        <div style="display: grid; grid-template-columns: 40% 60%; ">
            <div class="form-group" style="grid-column-start: 1;display: grid; grid-template-columns: 40% 60%; ">
                <label style="grid-column-start: 1;">%I.V.A: </label>
                <input readonly style="grid-column-start: 2;" id="PORCEN_IVA_INTERES" value="<?= $PORCEN_IVA_INTERES ?>" name="PORCEN_IVA_INTERES" type="text" class="form-control entero">
            </div>
            <div class="form-group" style="grid-column-start: 2;display: grid; grid-template-columns: 30% 70%; ">
                <label style="grid-column-start: 1;">&nbsp; I.V.A: </label>
                <input readonly style="grid-column-start: 2;" value="<?=$TOTAL_INTERESES_IVA?>" name="TOTAL_INTERESES_IVA" id="INTERES_IVA" type="text" class="form-control entero">
            </div>
        </div>