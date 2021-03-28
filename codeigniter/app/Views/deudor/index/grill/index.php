 <?php

use App\Helpers\Mobile_Detect;

if( (new Mobile_Detect())->isMobile())
echo view("deudor/index/grill/mobile");
else 
echo view("deudor/index/grill/desktop");
 
 ?>