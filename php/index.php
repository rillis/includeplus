<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Loading.
    
    <script src='scripts/ensureViewPort.js'></script>
    <script>
      if(!window.mobileCheck()){
        window.location.href = "/pc";
      }else{
        window.location.href = "/m";
      }
    </script>
  </body>
</html>
