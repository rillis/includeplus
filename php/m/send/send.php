<?php
$root = "../../";
include($root.'functions/validate_login.php');

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}


if (!isLogged("mob")){
    header('Location: /m/login');
    exit();
}

if(isset($_POST['user_lat']) && isset($_POST['user_lon']) && isset($_POST['location_id']) && isset($_POST['titulo']) && isset($_FILES['image'])){

    $upload_dir = $root.'posts/';

    global $root;
    include($root.'functions/connect.php');

    $loc_id = intval($_POST['location_id']);
    if($loc_id == -1){
        $query = "INSERT INTO posts(place_id, posts.place_request_name, posts.latitude, posts.longitude, user_id, photo, title, created_at) values (-1,?,?,?,?,'post.png',?,now())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sddis", $_POST['location'], $_POST['user_lat'], $_POST['user_lon'], $_SESSION['id'], $_POST['titulo']);
        $result = $stmt->execute();

        $id = $connection->insert_id;

    }else{
        $query = "INSERT INTO posts(place_id, posts.latitude, posts.longitude, user_id, photo, title, created_at) values (?,?,?,?,'post.png',?,now())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("iddis", $_POST['location_id'], $_POST['user_lat'], $_POST['user_lon'], $_SESSION['id'], $_POST['titulo']);
        $result = $stmt->execute();

        $id = $connection->insert_id;
    }

    $upload_dir = $upload_dir . $id . '/';

    if(!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir. 'post.png')){
        header('Location: /m?msg=Envio submetido, agora é só esperar algum dos nossos administradores aprovar!');
    }else{
        if(is_dir($upload_dir)) {
            deleteDirectory($upload_dir);
        }
        $stmt = $connection->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();


        header('Location: /m?error=Erro fatal de envio, contate nosso suporte e mencione o erro: FILE'.$_FILES["image"]["error"].'|'.$_FILES["image"]["size"]);
    }


}else if(isset($_POST['post_id']) && isset($_POST['titulo']) && isset($_FILES['image'])){

    $upload_dir = $root.'removals/';

    global $root;
    include($root.'functions/connect.php');

    $query = "INSERT INTO removals(post_id, user_id, photo, title, created_at) values (?,?,'removal.png',?,now())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iis", $_POST['post_id'], $_SESSION['id'], $_POST['titulo']);
    $result = $stmt->execute();

    $id = $connection->insert_id;

    $upload_dir = $upload_dir . $id . '/';

    if(!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir. 'removal.png')){
        header('Location: /m?msg=Envio submetido, agora é só esperar algum dos nossos administradores aprovar!');
    }else{
        if(is_dir($upload_dir)) {
            deleteDirectory($upload_dir);
        }
        $stmt = $connection->prepare("DELETE FROM removals WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();


        header('Location: /m?error=Erro fatal de envio, contate nosso suporte e mencione o erro: FILE'.$_FILES["image"]["error"].'|'.$_FILES["image"]["size"]);
    }

}else{
    header('Location: /m');
}

