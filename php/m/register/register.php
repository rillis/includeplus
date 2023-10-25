<?php
$root = "../../";
include($root.'functions/validate_login.php');

if (isLogged("mob")){
    header('Location: /m');
}

if(isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["cpf"]) && isset($_POST["nome"]) && !isset($_SESSION["token"])){
    $error = "";

    $user = $_POST['user'];
    $cpf = intval(str_replace(array('.', '-'), '', $_POST['cpf']));
    $nome = $_POST['nome'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    global $root;
    include($root.'functions/connect.php');

    $query = "SELECT id FROM users WHERE user = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $error = "Usuário já cadastrado";
        header("Location: /m/register?error=".$error);
        exit();
    }

    $query = "SELECT id FROM users WHERE cpf = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $error = "CPF já cadastrado";
        header("Location: /m/register?error=".$error);
        exit();
    }

    $query = "INSERT INTO users(name, user, cpf, password, created_at) VALUES (?,?,?,?,now())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssis", $nome, $user, $cpf, $pass);
    $stmt->execute();

    $stmt->close();

    header("Location: /m/login?msg=Usuario Cadastrado!");
    exit();

}
header("Location: /m/login");
?>
