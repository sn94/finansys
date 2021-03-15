<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FINANWEB</title>

  <!-- Custom Theme Style -->
  <link href="<?= base_url("assets/merged.css") ?>" rel="stylesheet">
  <link href="<?= base_url("assets/pnotify.css") ?>" rel="stylesheet">
  <link href="<?= base_url("assets/pnotify.buttons.css") ?>" rel="stylesheet">
  <style>
    /* merged.css | http://localhost/finansys/assets/merged.css */

    .login_content {
      background: white;
      padding: 5px;
    }

    .form-control {
      /* font-size: 14px; */
      /* background-color: #fff; */
      font-size: 18px;
      background-color: #b7b7b7;
    }

    /* Elemento | http://localhost/finansys/usuario/sign-in */

    .btn {
      background-color: #3951d6;
      color: wheat;
      font-size: 18px;
      border-radius: 20px;
    }
  </style>
</head>

<body class="login" style="background-color: #2a3f54!important;">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper" style="padding-left: 1px;">
      <div class="animate form login_form">
        <section class="login_content">
        <img class="img-responsive" src="<?= base_url("assets/img/BACKGROUND.jpg") ?>" alt="">
          <?php echo form_open("usuario/sign_in",    ['id' => "form-login"]);  ?>
          <h1>LOGIN</h1>
          <div>
            <input name="NICK" type="text" class="form-control" placeholder="nickname" required="" />
          </div>
          <div>
            <input name="PASS" type="password" class="form-control" placeholder="Password" required="" />
          </div>
          <div>
            <div style="font-weight: 600; color:red;"><?= isset($MENSAJE) ? $MENSAJE : "" ?></div>
            <button class="btn btn-default submit" type="submit">INGRESAR</button>

          </div>

          <div class="clearfix"></div>

          <div class="separator">


            <div class="clearfix"></div>
            <br />

            <div>
            

            </div>
          </div>
          </form>
        </section>
      </div>


    </div>
  </div>
</body>

</html>