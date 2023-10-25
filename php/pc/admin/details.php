<?php
$root = "../../";
include($root.'functions/validate_login.php');

if (!isLogged("pc")) {
    //session_start();
    header('Location: /pc/admin/login');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src='../../functions/ensureViewPort.js'></script>
    <script>
        if(window.mobileCheck()){
            window.location.href = "/m";
        }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>



    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link href="../assets/css/admin_panel.css" rel="stylesheet" />
</head>
<body>

<div class="d-flex justify-content-start">
    <div class="d-flex flex-column side-menu sticky-top" style="">
        <div class="logo"><a class="navbar-brand fw-bold" href="/pc">Include+</a></div>
        <div class="p-2 side-menu-item"><a class="navbar-brand" href="/pc/admin?page=pending_posts">Pending Posts</a></div>
        <div class="p-2 side-menu-item"><a class="navbar-brand" href="/pc/admin?page=pending_removals">Pending Removals</a></div>
        <div class="p-2 side-menu-item"><a class="navbar-brand" href="/pc/admin?page=posts">All Posts</a></div>
        <div class="p-2 side-menu-item logout"><a class="navbar-brand" href="/pc/admin/login/logout.php">Logout</a></div>
    </div>
    <div class="content d-flex align-items-start flex-wrap" style="width:100%">
        <div class="details_content"  style="width:100%">
            <?php
                if(isset($_GET['type']) && isset($_GET['id'])){
                    $type = $_GET['type'];
                    $id = $_GET['id'];

                    if($type == "pending_posts"){
                        global $root;
                        include($root.'functions/connect.php');


                        $result = $connection->query('SELECT a.*, b.name, b.user, b.cpf, b.role FROM posts a LEFT JOIN users b ON a.user_id = b.id WHERE a.id = '.$id);

                        if ($result->num_rows === 1) {
                            $row = $result->fetch_assoc();

                            $place_id = $row['place_id'];

                            $user_id = $row['user_id'];
                            $photo = $row['photo'];
                            $title = $row['title'];
                            $approved_by = $row['approved_by'];
                            $dennied_by = $row['dennied_by'];
                            $created_at = $row['created_at'];

                            $lat = $row['latitude'];
                            $lon = $row['longitude'];

                            $user = $row['user'];

                            ?>
                                <h1><?=$title?> (<?=$id?>)</h1>
                                <h5>Created by: <?=$user?> (<?=$user_id?>)</h5><br>

                                <form action="edit.php" method="POST">
                                    <div class="info d-flex flex-row">
                                        <div class="p-2">
                                            <h5>Title: </h5>
                                        </div>
                                        <div class="p-2">
                                            <input type="text" name="title" value="<?=$title?>" style="width:60vw;"/>
                                        </div>
                                    </div>
                                    <div class="info flex-column">
                                        <div class="p-2">
                                            <h5>Photo: </h5>
                                        </div>
                                        <div class="p-2">
                                            <img src="/posts/<?=$id?>/post.png" style="max-width:30vw;max-height:50vh"/>
                                        </div>
                                    </div>
                                    <div class="info flex-column">
                                        <div class="p-2">
                                            <h5>Location: <a href="https://www.google.com/maps/?q=<?=$lat?>,<?=$lon?>" target="_blank">Maps</a></h5>
                                        </div>
                                    </div>
                                    <div class="info d-flex flex-row">
                                        <div class="p-2">
                                            <h5>Location ID: </h5>
                                        </div>
                                        <div class="p-2">
                                            <?php

                                            if ($place_id == -1){
                                                echo '<input type="text" name="loc_id" value="" style="width:30vw;" required=""/>';
                                            }else{
                                                echo '<input type="text" name="loc_id" value="'.$place_id.'" style="width:30vw;" required=""/>';
                                            }
                                            ?>

                                        </div>

                                        <?php

                                        if ($place_id == -1){
                                            echo '<div class="p-2"><h5>Localização não definida, por favor <a href="location.php?pre_name='.$row["place_request_name"].'&pre_lat='.$lat.'&pre_lon='.$lon.'" target="_blank">clique aqui</a> para definir uma.</h5></div>';
                                        }else{

                                            $result2 = $connection->query('SELECT * FROM places a WHERE a.id = '.$place_id);

                                            if ($result2->num_rows === 1) {
                                                $row2 = $result2->fetch_assoc();


                                            }
                                            echo '<div class="p-2"><h5>Localização sugerida pelo usuario: <a href="https://www.google.com/maps/?q='.$row2['latitude'].','.$row2['longitude'].'" target="_blank">'.$row2['display_name'].'</a>. Criar uma <a href="location.php" target="_blank">nova</a>?</h5></div>';


                                        }
                                        ?>



                                    </div>
                                    <div class="info flex-column">
                                        <div class="p-2">
                                            <input type="hidden" id="result" name="result" />
                                            <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                            <button class="btn btn-primary" type="submit" onclick="document.getElementById('result').value='ap';">Aprovar</button>
                                            <button class="btn btn-danger" type="submit" onclick="document.getElementById('result').value='rp';">Negar</button>
                                        </div>
                                    </div>
                                </form>

                            <?php
                        }else{
                            echo '<div class="p-3"><div class="alert alert-danger" role="alert">FATAL ERROR</div></div>';
                        }
                    }else{
                        echo '<div class="p-3"><div class="alert alert-danger" role="alert">URL Mal Formatado.</div></div>';
                    }
                }

            ?>
        </div>
    </div>
</div>

<script src="../assets/js/jquery-3.7.0.min.js"></script>
<script src="../assets/js/datatables.min.js"></script>
<script>
    let table = new DataTable('#DataTable');
    $(document).ready(function() {
        document.getElementsByTagName("html")[0].style.visibility = "visible";
    });
</script>

</body>
</html>
