<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <script src='../functions/ensureViewPort.js'></script>
    <script>
      if(!window.mobileCheck()){
        window.location.href = "/pc";
      }
    </script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Mobile.

    <script>

      if ("geolocation" in navigator) {
        // Obtém a geolocalização do usuário
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Faça o que quiser com a latitude e a longitude
            alert(latitude + " | "+ longitude);
        }, function(error){
          if(error.code === 1){
            window.location.href = "/m/error.php?error=Parece que você negou a permissão de geolocalização, por favor aceite.";
          }else{
            window.location.href = "/m/error.php?error=Por favor entre em contato com o nosso suporte. Erro: "+error.message;
          }
        });
    } else {
      window.location.href = "/m/error.php?error=Por favor entre em contato com o nosso suporte. Erro: Critical error";
    }
    </script>
  </body>
</html>
