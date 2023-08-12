<?php
session_start();

if(isset($_SESSION['token']) && isset($_SESSION['created']) && isset($_SESSION['until']) && isset($_SESSION['user']) && isset($_SESSION['id'])){

    $currentTime = time();
    $sessionUntil = $_SESSION['until'];

    if ($currentTime > $sessionUntil || md5($_SESSION['created'] . $_SESSION['user']) != $_SESSION['token']) {
        session_unset();
        session_destroy();
    }
}else{
  session_unset();
  session_destroy();
}
?>
