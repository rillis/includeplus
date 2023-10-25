<?php
$root = "../../";
include($root.'functions/validate_login.php');
if (isLogged("mob")){
    header('Location: /m');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src='<?=$root?>functions/ensureViewPort.js'></script>
    <script>
        if(!window.mobileCheck()){
            window.location.href = "/pc";
        }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link href="../assets/css/login_mob.css" rel="stylesheet" />
</head>
<body class="">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <img src="../assets/img/logo_max.png" class="img_logo" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <form action="login.php" method="POST" class="signin-form mb-3" data-bitwarden-watching="1">
                        <div class="form-group mb-1">
                            <input type="text" name="user" class="form-control" placeholder="Usuário" required="">
                        </div>
                        <div class="form-group mb-2">
                            <input id="password-field" name="pass" type="password" class="form-control" placeholder="Senha" required="">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-success submit px-3">Entre</button>
                        </div>
                    </form>
                    <p class="w-100 text-center" style="color:white;">Não tem uma conta? <a href="/m/register">Cadastre-se gratuitamente</a>!</p>

                    <?php
                        if(isset($_GET["error"])){
                            echo '<div class="p-3"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
                        }

                        if(isset($_GET["msg"])){
                            echo '<div class="p-3"><div class="alert alert-info" role="alert">'.$_GET['msg'].'</div></div>';
                        }

                    ?>


                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

