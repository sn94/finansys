 <?php

use App\Helpers\Mobile_Detect;

if( (new Mobile_Detect())->isMobile())
echo view("deudor/grill_mobile");
else 
echo view("deudor/grill_desktop");
 
 ?>