<?php

$root = "";
?>
<html lang="pt-br" dir="ltr">
  <head>
    <script src='<?=$root?>functions/ensureViewPort.js'></script>
    <script>
      if(!window.mobileCheck()){
        window.location.href = "/pc";
      }else{
        window.location.href = "/m";
      }
    </script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
