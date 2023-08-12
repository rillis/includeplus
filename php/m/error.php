<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <script src='../scripts/ensureViewPort.js'></script>
    <script>
      if(!window.mobileCheck()){
        window.location.href = "/pc";
      }
    </script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      if(!isset($_GET['error'])){
        header('Location: /m');
      }else{
        echo $_GET['error'];
      }
    ?>

    <a href="/m">Voltar</a>
  </body>
</html>
