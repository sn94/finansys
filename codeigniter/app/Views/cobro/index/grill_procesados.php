<?php

use App\Helpers\Mobile_Detect;

if(  (new Mobile_Detect())->isMobile())
echo view("cobro/index/grill_procesados_mobile");
else 
echo view("cobro/index/grill_procesados_desktop");
?>