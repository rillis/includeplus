<?php
$root = "../../";
include($root.'functions/validate_login.php');

if (isLogged("mob")){
    header('Location: /m');
}

if(isset($_POST["user"]) && isset($_POST["pass"]) && !isset($_SESSION["token"])){
    $user = $_POST['user'];
    $pass2 = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $pass = $_POST['pass'];

    global $root;
    include($root.'functions/connect.php');

    $query = "SELECT id, user, password FROM users WHERE user = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if(password_verify($pass, $row['password'])){
            $_SESSION['created'] = time();
            $_SESSION['user'] = $row['user'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['until'] = $_SESSION['created'] + (9999 * 60); //30 minutos
            $_SESSION['token'] = md5($_SESSION['created'] . $_SESSION['user']);
            $_SESSION['mob'] = 0;

            $stmt->close();
            header("Location: /m");
            exit();
        }
    }

    $stmt->close();
    header("Location: /m/login?error=Credenciais incorretas.");
    exit();

}
header("Location: /m");
exit();
?>
