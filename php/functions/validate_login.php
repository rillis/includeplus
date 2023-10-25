<?php
session_start();

function isLogged($view){
    $anti = "mob";
    if ($view=="mob"){
        $anti = "pc";
    }

    if( isset($_SESSION['token']) && isset($_SESSION['created']) &&
        isset($_SESSION['until']) && isset($_SESSION['user']) &&
        isset($_SESSION['id']) && isset($_SESSION[$view]) &&
        !isset($_SESSION[$anti])
    ){
        $currentTime = time();
        $sessionUntil = $_SESSION['until'];

        if ($currentTime <= $sessionUntil && md5($_SESSION['created'] . $_SESSION['user']) == $_SESSION['token']) {
            return true;
        }
    }
    return false;
}
?>