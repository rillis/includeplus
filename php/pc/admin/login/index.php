<?php
$root = "../../../";
include($root.'functions/validate_login.php');

if (isLogged("pc")){
  header('Location: /pc/admin');
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <script src='<?=$root?>functions/ensureViewPort.js'></script>
    <script>
      if(window.mobileCheck()){
        window.location.href = "/m";
      }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../../assets/css/admin_login.css" rel="stylesheet" />

  </head>
  <body>
    <form class="" action="login.php" method="post">
<div class="d-flex flex-column justify-content-center align-items-center" style="height:100vh;">

  <div class="form-div d-flex flex-column justify-content-center align-items-center">
        <div class="p-4">
          <img src="../../assets/img/logo_max.png" style="width:20vw;" />
        </div>
        <div class="p-1 form-group">
          <input type="text" name="user" value="" class="form-control" placeholder="Username" style="width:20vw;">
        </div>
        <div class="p-1 form-group">
          <input type="password" name="pass" value="" class="form-control" placeholder="Password"  style="width:20vw;">
        </div>
        <div class="p-2">
          <input type="submit" value="Admin Login" class="btn btn-dark mb-2"  style="width:10vw;">
          <a href="/pc"><input type="button" value="Go Back" class="btn btn-danger mb-2"  style="width:8vw;"></a>
        </div>
      </div>



    <?php
      if(isset($_GET['error'])){
        echo '<div class="p-3" style="width:70vw;"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
      }
    ?>
</div>
</form>
  </body>
</html>
