<?php
session_start();

function isLogged(){
  if( isset($_SESSION['token']) && isset($_SESSION['created']) &&
      isset($_SESSION['until']) && isset($_SESSION['user']) &&
      isset($_SESSION['id']) && isset($_SESSION['pc']) &&
      !isset($_SESSION['mob'])
    ){
      $currentTime = time();
      $sessionUntil = $_SESSION['until'];

      if ($currentTime <= $sessionUntil && md5($_SESSION['created'] . $_SESSION['user']) == $_SESSION['token']) {
          return true;
      }
  }

  return false;
}

if(!isLogged()){
  session_unset();
  session_destroy();
  session_start();
}
?>
