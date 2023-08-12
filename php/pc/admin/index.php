<?php
include('login/validate_login.php');

if (!isset($_SESSION['token'])){
  header('Location: /pc/admin/login');
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <script src='scripts/ensurePC.js'></script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../css/styles.css" rel="stylesheet" />
  </head>
  <body>
      ADMIN PANEL <a href="login/logout.php">Logout</a>
  </body>
</html>
