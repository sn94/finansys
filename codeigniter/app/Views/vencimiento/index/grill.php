
<?php

use App\Helpers\Mobile_Detect;

$ES_MOBILE=  (new Mobile_Detect())->isMobile() ;

if(  $ES_MOBILE )  
echo view("vencimiento/index/grill_mobile");
else
echo view("vencimiento/index/grill_desktop");
?>
 