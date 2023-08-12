<?php
include('validate_login.php');

if (isset($_SESSION['token'])){
  header('Location: /pc/admin');
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <script src='scripts/ensurePC.js'></script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../../css/styles.css" rel="stylesheet" />
  </head>
  <body>

      LOGIN PAGE

      <form class="" action="login.php" method="post">
          <input type="text" name="user" value="">
          <input type="password" name="pass" value="">
          <input type="submit" value="Enviar">
      </form>

  </body>
</html>
