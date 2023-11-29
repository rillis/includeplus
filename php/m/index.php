<?php
$root = "../";
include($root.'functions/validate_login.php');
include($root.'functions/tempo.php');

if (!isLogged("mob")){
    header('Location: /m/login');
}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='<?=$root?>functions/ensureViewPort.js'></script>
    <script>
        if(!window.mobileCheck()){
            window.location.href = "/pc";
        }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/datatables.min.css" />
    <link href="assets/css/mob.css" rel="stylesheet" />
</head>
<body class="">
<div class="ftco-section">
    <div class="container">
        <div class="row justify-content-center logo">
            <div class="col-md-6 text-center mb-5">
                <img src="assets/img/logo_max.png" class="img_logo" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<a href="/m/send">
    <div class="bubble d-flex justify-content-center align-items-center navbar_med">
        <img src="assets/img/plus.png" class="bubble_img" />
    </div>
</a>


<div class="debug" style="height:3vh"></div>

<?php
    if(isset($_GET["error"])){
        echo '<div class="p-3"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
    }

    if(isset($_GET["msg"])){
        echo '<div class="p-3"><div class="alert alert-info" role="alert">'.$_GET['msg'].'</div></div>';
    }
?>


<h2 style="color:white">Ultimos envios:</h2>

<?php
global $root;
include($root.'functions/connect.php');

$result = $connection->query('SELECT a.*, b.display_name, b.address FROM vw_active_posts a LEFT JOIN places b ON a.place_id = b.id ORDER BY a.created_at desc limit 20');

foreach($result as $row) {
    ?>
    <div class="post d-flex align-items-start flex-column">
        <a href="/m/search?id=<?=$row["place_id"]?>"><span class="post_place"><?=$row["display_name"]?></span></a>
        <span class="post_place_addr"><?=$row["address"]?></span>
        <span class="post_title"><?=$row["title"]?></span>
        <div class = "post_img_holder d-flex justify-content-center align-items-center">
            <img src="../posts/<?=$row["id"]?>/post.png" class="post_img"/>
        </div>
        <a href="/m/send?removal=1&post=<?=$row["id"]?>"><span class="post_created" style="margin-top:10px;color:#f87171">Esse problema já foi corrigido? Clique aqui</span></a>
        <span class="post_created"><?=tempoAtras($row["created_at"])?></span>
    </div>
    <?php
}


?>











<div class="debug"></div>

<div class="navbar_bottom">
    <div class="d-flex justify-content-center align-items-center navbar_med">
        <div class="col-xs-1 navbar_item">
            <a href="/m/"><img src="assets/img/home_on.png" class="navbar_img" /></a>
        </div>
        <div class="col-xs-1 navbar_item">
            <a href="/m/search"><img src="assets/img/search_off.png" class="navbar_img" /></a>
        </div>
        <div class="col-xs-1 navbar_item">
            <a href="/m/profile"><img src="assets/img/profile_off.png" class="navbar_img" /></a>
        </div>
    </div>
</div>


</body>
</html>

