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
    <script src='../assets/js/jquery-3.7.1.min.js'></script>
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
                    <form action="register.php" method="POST" class="signin-form mb-3" data-bitwarden-watching="1">
                        <div class="form-group mb-1">
                            <input name="nome" type="text" class="form-control inp" placeholder="Nome Completo" required="">
                        </div>
                        <div class="form-group mb-1">
                            <input name="cpf" type="text" id="cpf" class="form-control inp" placeholder="CPF (somente números)" required="">
                        </div>
                        <span id="cpf-validate" style="color:white; display:none;" class="mb-2">a</span>

                        <div class="form-group mb-1">
                            <input name="user" type="text" id="user" class="form-control inp" placeholder="Usuário" required="">
                        </div>
                        <span id="user-validate" style="color:white; display:none;" class="mb-2">a</span>

                        <div class="form-group mb-1">
                            <input name="pass" id="password" type="password" class="form-control pass inp" placeholder="Senha" required="">
                        </div>
                        <span id="password-strength" style="color:white; display:none;" class="mb-2">a</span>

                        <div class="form-group mb-1">
                            <input id="password-2" type="password" class="form-control pass inp" placeholder="Confirme a senha" required="">
                        </div>
                        <span id="password-match" style="color:white; display:none;" class="mb-1">a</span>



                        <div class="form-group">
                            <button type="submit" id="submit" class="form-control btn btn-success submit px-3 mt-3" disabled>Cadastrar</button>
                        </div>
                    </form>
                    <p class="w-100 text-center" style="color:white;">Já tem uma conta? <a href="/m/login">Clique aqui para entrar</a>!</p>

                    <?php
                    if(isset($_GET["error"])){
                        echo '<div class="p-3"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function validaCPF(cpf) {
        var soma;
        var resto;
        soma = 0;
        if (cpf == "00000000000") return false;

        for (i = 1; i <= 9; i++) soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        resto = (soma * 10) % 11;

        if ((resto == 10) || (resto == 11)) resto = 0;
        if (resto != parseInt(cpf.substring(9, 10))) return false;

        soma = 0;
        for (i = 1; i <= 10; i++) soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        resto = (soma * 10) % 11;

        if ((resto == 10) || (resto == 11)) resto = 0;
        if (resto != parseInt(cpf.substring(10, 11)) ) return false;
        return true;
    }


    $(document).ready(function() {
        $('#password').on('input', function() {
            var password = $(this).val();
            var error = "";

            if (password.length < 8) {
                error = "A senha deve conter pelo menos 8 caracteres."
            }else if (!(password.match(/[a-z]/) && password.match(/[A-Z]/))) {
                error = "A senha deve ter pelo menos uma letra maiuscula e uma minuscula."
            }else if (!(password.match(/\d/))) {
                error = "A senha deve conter pelo menos um número."
            }else if (!(password.match(/[^a-zA-Z\d]/))) {
                error = "A senha deve conter pelo menos uma caracetere especial."
            }

            // Update the text and color based on the password strength
            var passwordStrengthElement = $('#password-strength');

            if (error === ""){
                passwordStrengthElement.css('display', 'none');
            }else{
                passwordStrengthElement.text(error);
                passwordStrengthElement.css('color', 'red');
                passwordStrengthElement.css('display', 'block');
            }
        });

        $('.pass').on('input', function() {
            var password = $('#password').val();
            var password2 = $('#password-2').val();

            var passwordMatchElement = $('#password-match');

            if (password2 === password){
                passwordMatchElement.css('display', 'none');
            }else{
                passwordMatchElement.text('As senhas não coincidem.');
                passwordMatchElement.css('color', 'red');
                passwordMatchElement.css('display', 'block');
            }
        });

        $('#user').on('input', function() {
            var text = $(this).val();
            var error = "";

            if (text.length < 6) {
                error = "O nome de usuário deve conter no minimo 6 caracteres";
            }else if((text.match(/[^a-zA-Z0-9.]/))){
                error = "O nome de usuário deve conter apenas letras e números";
            }



            var elem = $('#user-validate');
            if (error === ""){
                elem.css('display', 'none');
            }else{
                elem.text(error);
                elem.css('color', 'red');
                elem.css('display', 'block');
            }
        });

        $('#cpf').on('input', function() {
            var raw_text = $(this).val();
            var text = raw_text.replace(/[^0-9]/g, "");
            var error = "";

            if(text.length != 11){
                error = "Quantidade de numeros não bate com um CPF (11)."
            }else if(raw_text.match(/[^0-9.-]/)){
                error = "Caractere invalido.";
            }else if(!((raw_text.match(/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/)) || (raw_text.match(/([0-9]{11})/)))){
                error = "Formatação incorreta.";
            }else if(!validaCPF(text)){
                error = "CPF invalido.";
            }



            var elem = $('#cpf-validate');
            if (error === ""){
                elem.css('display', 'none');
            }else{
                elem.text(error);
                elem.css('color', 'red');
                elem.css('display', 'block');
            }
        });



        $('.inp').on('input', function() {
            var submit = $('#submit');

            submit.prop("disabled", false);

            if(($('#password-match').css("display")!=="none")){
                submit.prop("disabled", true);
                return;
            }
            if(($('#password-strength').css("display")!=="none")){
                submit.prop("disabled", true);
                return;
            }
            if(($('#user-validate').css("display")!=="none")){
                submit.prop("disabled", true);
                return;
            }
        });
    });

</script>


</body>
</html>

