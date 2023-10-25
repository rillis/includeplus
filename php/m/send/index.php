<?php
$root = "../../";
include($root.'functions/validate_login.php');
include($root.'functions/tempo.php');

if (!isLogged("mob")){
    header('Location: /m/login');
}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='<?=$root?>functions/ensureViewPort.js'></script>
    <script>
        if(!window.mobileCheck()){
            window.location.href = "/pc";
        }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link href="../assets/css/mob.css" rel="stylesheet" />
</head>
<body class="">


<div class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <img src="../assets/img/logo_max.png" class="img_logo" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">

                    <?php

                        if(!(isset($_GET['removal']))){
                            ?>
                                <form action="send.php" method="POST" enctype="multipart/form-data" class="signin-form mb-3" data-bitwarden-watching="1">

                                    <input type="hidden" id="user_lat" name="user_lat">
                                    <input type="hidden" id="user_lon" name="user_lon">
                                    <?php
                                    if(isset($_GET["placeid"])){
                                        echo '<input type="hidden" id="location_id" name="location_id" value='.$_GET["placeid"].'>';
                                    }else{
                                        echo '<input type="hidden" id="location_id" name="location_id" value=-1>';
                                    }
                                    ?>

                                    <div class="form-group mb-3">
                                        <span style="color:white;">Digite o nome do estabelecimento, com detalhes. Ex: Shopping Itaquera piso 2</span>
                                        <?php
                                        if(isset($_GET["placeid"])){
                                            global $root;
                                            include($root.'functions/connect.php');

                                            $result = $connection->query('SELECT a.* FROM places a WHERE a.id = '.$_GET["placeid"]);

                                            if ($result->num_rows === 1) {
                                                $row = $result->fetch_assoc();
                                                $name = $row["display_name"];
                                            }

                                            echo '<input type="text" id="name" name="location" class="form-control" placeholder="Local" required="" disabled="" value="'.$name.'">';
                                            echo '<span style="color:red" id="name_removal" onclick="remove()">Esse local está incoreto? Clique aqui para remover</span>';

                                        }else{
                                            echo '<input type="text" id="name" name="location" class="form-control" placeholder="Local" required="">';
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <span style="color:white;">De um titulo para sua solicitação. Ex: Falta de rampa no acesso B.</span>
                                        <input type="text" name="titulo" class="form-control" placeholder="Titulo" required="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <span style="color:white;">Anexe uma foto que mostre bem o problema, você pode tirar ou selecionar da galeria.</span>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="52428800" />
                                        <input type="file" name="image" class="form-control-file" accept="image/*" id="file-input" capture="environment" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-success submit px-3">Enviar para analise</button>
                                    </div>
                                </form>
                            <?php
                        }else{
                            ?>
                                <form action="send.php" method="POST" enctype="multipart/form-data" class="signin-form mb-3" data-bitwarden-watching="1">
                                    <input type="hidden" id="user_lat" name="user_lat">
                                    <input type="hidden" id="user_lon" name="user_lon">

                                    <input type="hidden" id="post_id" name="post_id" value="<?=$_GET['post']?>">

                                    <div class="form-group mb-3">
                                        <span style="color:white;">Explique como o problema foi corrigido.</span>
                                        <input type="text" name="titulo" class="form-control" placeholder="Titulo" required="">
                                    </div>

                                    <div class="form-group mb-3">
                                        <span style="color:white;">Anexe uma foto que mostre bem a solução problema, você pode tirar ou selecionar da galeria.</span>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="52428800" />
                                        <input type="file" name="image" class="form-control-file" accept="image/*" id="file-input" capture="environment" required=""/>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-success submit px-3">Enviar para analise</button>
                                    </div>
                                </form>
                            <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="debug" style="height:3vh"></div>


<script>
    function remove(){
        document.getElementById("name").value = "";
        document.getElementById("location_id").value = -1;
        document.getElementById('name').removeAttribute('disabled');
        document.getElementById("name_removal").style.display = "none";
    }

    if ("geolocation" in navigator) {
        // Obtém a geolocalização do usuário
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;


            document.getElementById("user_lat").value = latitude;
            document.getElementById("user_lon").value = longitude;

            console.log(latitude + " | "+ longitude);
        }, function(error){
            window.location.href = "/m?error=Serviço indisponível: Não foi possível obter a sua geolocalização, aprove a notificação solicitada ou altere nas configurações do seu telefone.";

        });
    } else {
        window.location.href = "/m?error=Serviço indisponível: Não foi possível obter a sua geolocalização, aprove a notificação solicitada ou altere nas configurações do seu telefone.";

    }
</script>

</body>
</html>

