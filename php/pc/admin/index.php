<?php
include('login/validate_login.php');

if (!isset($_SESSION['token'])){
  header('Location: /pc/admin/login');
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../css/styles.css" rel="stylesheet" />
  </head>
  <body>
      ADMIN PANEL <a href="login/logout.php">Logout</a>

      <script src='../../scripts/ensureViewPort.js'></script>
      <script>
        if(window.mobileCheck()){
          window.location.href = "/m";
        }
      </script>
  </body>
</html>
