<?php
$root = "../../";
include($root.'functions/validate_login.php');

if(isset($_POST['title']) && isset($_POST['loc_id']) && isset($_POST['result']) && isset($_POST['id'])){

    $var_name = 'dennied_by';
    if($_POST['result']=="ap"){
        $var_name = 'approved_by';
    }

    global $root;
    include($root.'functions/connect.php');

    $query = "UPDATE posts SET title=?, place_id=?, place_request_name=null, ".$var_name."=? WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("siii", $_POST['title'], $_POST['loc_id'], $_SESSION['id'], $_POST['id']);
    $result = $stmt->execute();

    header('Location: /pc/admin?msg=Post editado');
}else{
    header('Location: /pc/admin?error=URL Malformed');
}
