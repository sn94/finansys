<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> PRESTASYS v.2020</title>

    <!-- Custom Theme Style -->
    <link href="<?= base_url("assets/merged.css")?>" rel="stylesheet">
    <link href="<?= base_url("assets/pnotify.css")?>" rel="stylesheet">
    <link href="<?= base_url("assets/pnotify.buttons.css")?>" rel="stylesheet">
  </head>

  <body class="login" style="background-color: #2a3f54!important;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper" style="padding-left: 1px;">
        <div class="animate form login_form">
          <section class="login_content">
          <?php  echo form_open( "usuario/sign_in",    ['id'=> "form-login"   ]);  ?> 
              <h1>INICIAR SESIÓN</h1>
              <div>
                <input name="NICK" type="text" class="form-control" placeholder="nickname" required="" />
              </div>
              <div>
                <input name="PASS" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <div style="font-weight: 600; color:red;"><?= isset($MENSAJE) ? $MENSAJE : "" ?></div>
                <button class="btn btn-default submit"  type="submit">INGRESAR</button>
                 
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                 

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1 style="color: #7671b3"><i class="fa fa-money fa-3x"></i>
                  
                 </h1>
                  <p>©<?=date("Y")?> Contacto del desarrollador: soniatoledo294@hotmail.com</p>
                </div>
              </div>
            </form>
          </section>
        </div>

       
      </div>
    </div>
  </body>
</html>
