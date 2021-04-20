<?php

use CodeIgniter\Session\Session;

$BASE_ASSETS = base_url('assets/template');
$BASE_ASSETS_BASE = base_url('assets');
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FINANWEB</title>

  
  <!-- jQuery -->
  <script src="<?= $BASE_ASSETS ?>/plugins/jquery/jquery.min.js"></script>
     <!-- Bootstrap 4 -->
    <script src="<?= $BASE_ASSETS ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>



  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/fontawesome-free/css/all.min.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/summernote/summernote-bs4.min.css">
  <!-- AUTO COMPLETADO -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS_BASE ?>/awesomplete/awesomplete.min.css">
  <!--  PNOTIFY -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS_BASE ?>/pnotify/pnotify.css">


  <style> 
  
  body{
    background-image: url(<?=base_url('assets/img/nature.jpg')?>);
    background-repeat: no-repeat;
    background-size: cover;
  }

 
.form-control::placeholder { 
  color: #0a3153 !important;
}

 
.form-control { 
  background-color: #8bced5  !important;
}

  .cobertor {
      background-color: #000000d1;position: absolute;
    }

    
    .btn {
      background-color: #3951d6;
      color: wheat;
      font-size: 18px;
      border-radius: 8px;
    }
  </style>
</head>

<body class="h-100 p-0  m-0"    >

  <div class="container-fluid h-100 m-0 p-0 cobertor" > 

    <div class="container bg-light  col-12 col-sm-11 col-md-4 pl-2 pr-3 pl-3 mt-3 mt-md-5 " style="border-radius: 8px;" > 
        <img  class="img-responsive w-50 d-block mx-auto" src="<?= base_url("assets/img/BACKGROUND.jpg") ?>" alt="">
          <?php echo form_open("usuario/sign_in",    ['id' => "form-login"]);  ?>
          <h4 class="text-center">Acceso</h4>
          <div>
            <input    name="NICK" type="text" class="form-control mb-2" placeholder="nickname" required="" />
          </div>
          <div>
            <input name="PASS" type="password" class="form-control mb-2" placeholder="Password" required="" />
          </div>
          <div style="display: flex; flex-direction: column;justify-content: center;">
            <div style="font-weight: 600; color:red;"><?= isset($MENSAJE) ? $MENSAJE : "" ?></div>
            <button class="btn  submit" type="submit">INGRESAR</button>

          </div>
          <div class="clearfix"></div>
          <div class="separator">
            <div class="clearfix"></div>
            <br />
            <div>
            </div>
          </div>
          </form>  
    </div>
  </div>
</body>

</html>