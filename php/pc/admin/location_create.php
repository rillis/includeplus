<?php
$root = "../../";
include($root.'functions/validate_login.php');

    if(isset($_POST['display_name']) && isset($_POST['lat'])&& isset($_POST['lon'])&& isset($_POST['address'])&& isset($_POST['cep'])){
        $display_name = $_POST['display_name'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];
        $address = $_POST['address'];
        $cep = $_POST['cep'];

        global $root;
        include($root.'functions/connect.php');

        $query = "INSERT INTO places(display_name, address, cep, latitude, longitude, created_by, created_at) values (?,?,?,?,?,?,now())";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssddi", $display_name, $address, $cep, $lat, $lon, $_SESSION['id']);
        $result = $stmt->execute();

        $id = $connection->insert_id;

        header('Location: /pc/admin/location.php?msg=Criado com o id: '.$id);
    }else{
        header('Location: /pc/admin/location.php?error=URL Malformed');
    }