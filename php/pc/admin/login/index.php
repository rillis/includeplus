<?php
include('validate_login.php');

if (isset($_SESSION['token'])){
  header('Location: /pc/admin');
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/adminpanel.css" rel="stylesheet" />

  </head>
  <body>
    <form class="" action="login.php" method="post">
<div class="d-flex flex-column justify-content-center align-items-center" style="height:100vh;">

      <div class="form-div d-flex flex-column justify-content-center align-items-center">
        <div class="p-4">
          <img src="../../assets/logo_max.png" style="width:20vw;" />
        </div>
        <div class="p-1 form-group">
          <input type="text" name="user" value="" class="form-control" placeholder="Username" style="width:20vw;">
        </div>
        <div class="p-1 form-group">
          <input type="password" name="pass" value="" class="form-control" placeholder="Password"  style="width:20vw;">
        </div>
        <div class="p-2">
          <input type="submit" value="Login" class="btn btn-primary mb-2"  style="width:10vw;">
        </div>
      </div>



    <?php
      if(isset($_GET['error'])){
        echo '<div class="p-3" style="width:70vw;"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
      }
    ?>
</div>
</form>





      <script src='../../../scripts/ensureViewPort.js'></script>
      <script>
        if(window.mobileCheck()){
          window.location.href = "/m";
        }
      </script>
  </body>
</html>
