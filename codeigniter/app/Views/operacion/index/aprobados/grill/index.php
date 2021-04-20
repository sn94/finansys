
<?php

use App\Helpers\Mobile_Detect;

$ES_MOBILE=  (new Mobile_Detect())->isMobile() ;
 
/*

Acciones permitidas para operaciones aprobadas:

1-ver cuotas
2-cobrar

ACCION_GRILL  VER_CUOTA |  COBRAR

*/
 

$params=  isset($COBRANZA) ? [ 'COBRANZA'=> 'SI']: [];
if(  $ES_MOBILE )  
echo view("operacion/index/aprobados/grill/mobile", $params);
else
echo view("operacion/index/aprobados/grill/desktop", $params);
?>
 