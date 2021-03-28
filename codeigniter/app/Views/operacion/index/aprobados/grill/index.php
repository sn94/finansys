
<?php

use App\Helpers\Mobile_Detect;

$ES_MOBILE=  (new Mobile_Detect())->isMobile() ;


/*

Acciones permitidas para operaciones aprobadas:

1-ver cuotas
2-cobrar

ACCION_GRILL  VER_CUOTA |  COBRAR

*/




if(  $ES_MOBILE )  
echo view("operacion/index/aprobados/grill/mobile");
else
echo view("operacion/index/aprobados/grill/desktop");
?>
 