<?php
$BASE_ASSETS = base_url('assets/template');
$BASE_ASSETS_BASE = base_url('assets');
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Sonia Toledo">

  <title>Finanweb</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $BASE_ASSETS ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
    @import url("<?= base_url('assets/Marvel-Regular.ttf') ?>");

    @font-face {
      font-family: "mainfont";
      src: url("<?= base_url('assets/Marvel-Regular.ttf') ?>");

    }


    /**Estilo d plantilla */
    [class*="sidebar-dark-"] {
      background-color: #3F51B5;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
    .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {

      background-color: #303F9F;
    }

    .brand-link {
      background-color: #303F9F;
    }

    .btn.btn-primary, .bg-primary {
      background-color: #3F51B5 !important;
      background: #3F51B5 !important;
    }




    .form-control {
      /* height: calc(2.25rem + 2px); */
      /* font-size: 1rem; */
      /* background-color: #fff; */
      height: calc( 2rem + 2px);
      font-size: 0.9rem;
      background-color: #B3E5FC;
      border: 1px solid #8c91d7;
    }



    h1,
    h2,
    h3,
    h4,
    h4,
    h5,
    h6,
    label,
    legend {
      font-family: mainfont;
    }


    /***fieldsets */

    fieldset {
      border: 1px solid #9999ca;
      padding: 1px 0px 1px 0px;

      /* margin-bottom: 2px;*/
      margin: 0px;
      width: 100%;
      height: 100%;
    }

    fieldset legend {
      text-align: center;
      padding-left: 5px;
      padding-top: 2px;
      border-radius: 6px 6px 0px 0px;
      background-color: #303F9F;
      /*#8eb9b5;*/
      color: white;
      text-shadow: 1px 1px 8px #04043c;
      font-size: 11pt;
      font-weight: 600;
    }

    fieldset label.sobrio {
      text-transform: capitalize;
      font-size: 9pt;
      font-weight: 600;
      color: #4d4d4d;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }



    /**awesomplete */

    #awesomplete_list_2 {
      z-index: 1000000;
      position: absolute;
      opacity: 1;
      background-color: #0072aa;
      color: wheat;
    }

    .visually-hidden {
      display: none;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader 
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= $BASE_ASSETS ?>/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
-->
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link"> </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link"> </a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">

          </a>
          <div class="navbar-search-block">

          </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown d-none">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="<?= $BASE_ASSETS ?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="<?= $BASE_ASSETS ?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="<?= $BASE_ASSETS ?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown d-none">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item d-none">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item d-none">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Sistema Financiero</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

          <div class="info">
            <a href="#" class="d-block">
              <i class="fa fa-user"></i>
              SUPERVISOR</a>
          </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          
            <li class="nav-item ">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
              CRÉDITOS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">


              <li class="nav-item">
                  <a href="<?= base_url("deudor/index") ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Clientes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("operacion/pendientes") ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Operaciones</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="<?= base_url("operacion/generar-vencimiento") ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Vencimientos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ofrecimientos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Planilla solicitudes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Referencias comerciales</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Operaciones pendientes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Datos de cédula</p>
                  </a>
                </li>
              </ul>
            </li>



            <li class="nav-item ">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  CAJA<span class="badge badge-warning">EN DESARROLLO</span>
                  <i class="fas fa-angle-left right"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  REQUERIMIENTO <span class="badge badge-warning">EN DESARROLLO</span>
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="#" class="nav-link">

                    <i class="far fa-circle nav-icon"></i>
                    <p>Opcion 1 </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Opcion 2</p>
                  </a>
                </li>



              </ul>
            </li>

            <li class="nav-item ">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  ESTADÍSTICA <span class="badge badge-warning">EN DESARROLLO</span>
                  <i class="fas fa-angle-left right"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>


            <li class="nav-item ">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  VARIOS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?= base_url("parametros/create") ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Parámetros</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?= base_url("empresa/index") ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Empresas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("porcentaje/index") ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Porcentajes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("letras/index") ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Letras</p>
                  </a>
                </li>

              </ul>
            </li>



        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">
                <?= $this->renderSection("title") ?>
              </h1>
            </div><!-- /.col -->
             
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">


        <div class="container-fluid p-0 m-0">
          <?= $this->renderSection("contenido") ?>
        </div>





        <div class="modal fade" id="modal-success" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content bg-success">
              <div class="modal-header">
                <h4 class="modal-title">Success Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p>One fine body…</p>
              </div>
              <div class="modal-footer justify-content-between">

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



        <div class="modal fade" id="modal-danger" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Danger Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p>One fine body…</p>
              </div>
              <div class="modal-footer justify-content-between">

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



      </section>




      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Año <?= date("Y") ?> <a href="#">Finanweb</a>.</strong>

      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0-rc
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->










  <!-- jQuery -->
  <script src="<?= $BASE_ASSETS ?>/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= $BASE_ASSETS ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= $BASE_ASSETS ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $BASE_ASSETS ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= $BASE_ASSETS ?>/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?= $BASE_ASSETS ?>/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?= $BASE_ASSETS ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= $BASE_ASSETS ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= $BASE_ASSETS ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= $BASE_ASSETS ?>/plugins/moment/moment.min.js"></script>
  <script src="<?= $BASE_ASSETS ?>/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= $BASE_ASSETS ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= $BASE_ASSETS ?>/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= $BASE_ASSETS ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= $BASE_ASSETS ?>/dist/js/adminlte.js"></script>
  <!--XLS GEN -->

  <script src="<?= $BASE_ASSETS_BASE ?>/xls_gen/xls.js<?= '?v='.microtime(true) ?>"></script>
  <script src="<?= $BASE_ASSETS_BASE ?>/xls_gen/xls_ini.js"></script>
  <!--AUTOCOMPLETADO -->
  <script src="<?= $BASE_ASSETS_BASE ?>/awesomplete/awesomplete.min.js"></script>
  <!--AUTOCOMPLETADO -->
  <script src="<?= $BASE_ASSETS_BASE ?>/pnotify/pnotify.js"></script>


  <script>
    function replaceAll_compat() {
      if (!("replaceAll" in String.prototype)) {
        let replaceAll = function(expre_reg, substitute) {
          return this.replace(expre_reg, substitute);
        };
        String.prototype.replaceAll = replaceAll;
      }
    }
    replaceAll_compat();

    window.alertSuccess = function({
      title,
      body
    }) {
      $("#modal-success .modal-title").text(title);
      $("#modal-success .modal-body").text(body);
      $("#modal-success").modal("show");
    };

    window.alertDanger = function({
      title,
      body
    }) {
      $("#modal-danger .modal-title").text(title);
      $("#modal-danger .modal-body").text(body);
      $("#modal-danger").modal("show");
    };
  </script>

</body>

</html>