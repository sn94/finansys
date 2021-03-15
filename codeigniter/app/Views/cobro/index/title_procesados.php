<?php

use App\Helpers\Mobile_Detect;

if ((new Mobile_Detect())->isMobile()) :
?>

    <div class=" mt-0 card-header card-header-primary p-0">

        <p style="font-size: 16px;font-weight: 600;" class="text-center text-primary m-0 "> OPERACIONES APROBADAS </p>
    </div>
<?php else : ?>
    <div class="card-header card-header-primary">

        <h2 class="text-center prestyle"> OPERACIONES APROBADAS <small></small></h2>
    </div>
<?php endif; ?>