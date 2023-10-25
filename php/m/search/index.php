<?php
$root = "../../";
include($root.'functions/validate_login.php');
include($root.'functions/tempo.php');
include($root.'functions/loc.php');

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

    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link href="../assets/css/mob.css" rel="stylesheet" />
</head>
<body class="">
<div class="ftco-section">
    <div class="container">
        <div class="row justify-content-center logo">
            <div class="col-md-6 text-center mb-5">
                <img src="../assets/img/logo_max.png" class="img_logo" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    aaa
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET["id"])){
    echo '<a href="/m/send?placeid='.$_GET["id"].'">';
}  else{
    echo '<a href="/m/send">';
}
?>
    <div class="bubble d-flex justify-content-center align-items-center navbar_med">
        <img src="../assets/img/plus.png" class="bubble_img" />
    </div>
</a>

<div class="debug" style="height:3vh"></div>


<?php

if(isset($_GET["id"])){
    //PROFILE PLACE

    global $root;
    include($root.'functions/connect.php');


    $result = $connection->query('SELECT a.* FROM places a WHERE a.id = '.$_GET["id"]);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $name = $row["display_name"];
        $address = $row["address"];
        $cep = $row["cep"];
        $latitude = $row["latitude"];
        $longitude = $row["longitude"];

        ?>
        <div class="d-flex align-items-start flex-column" style="margin-left:10px;">
            <span class="place_name"><?=$name?></span>
            <span class="place_addr"><?=$address?></span>
            <span class="place_addr"><?=$cep?></span>
        </div>
        <?php



    }else{
        echo '<div class="p-3"><div class="alert alert-danger" role="alert">Local não encontrado. (001)</div></div>';
        exit();
    }
    $result = $connection->query('SELECT a.*, b.display_name, b.address FROM vw_active_posts a INNER JOIN places b ON a.place_id = '.$_GET["id"].' and a.place_id = b.id ORDER BY a.created_at desc limit 100');
    if ($result->num_rows > 0) {
        foreach($result as $row) {
            ?>
            <div class="post d-flex align-items-start flex-column">
                <span class="post_title"><?=$row["title"]?></span>
                <div class = "post_img_holder d-flex justify-content-center align-items-center">
                    <img src="../../posts/<?=$row["id"]?>/post.png" class="post_img"/>
                </div>
                <a href="/m/send?removal=1&post=<?=$row["id"]?>"><span class="post_created" style="margin-top:10px;color:#f87171">Esse problema já foi corrigido? Clique aqui</span></a>
                <span class="post_created"><?=tempoAtras($row["created_at"])?></span>
            </div>
            <?php
        }
    }else{
        echo '<div class="p-3"><div class="alert alert-danger" role="alert">Posts não encontrados. (002)</div></div>';
    }


}else if(isset($_GET["s"])){
    //SEARCH TERM

                global $root;
                include($root.'functions/connect.php');

                $userLatitude = $_GET['user_lat'];
                $userLongitude = $_GET['user_lon'];
                $search = $_GET['s'];

                $query = "SELECT display_name, latitude, longitude, id, address FROM places WHERE display_name LIKE '%".$search."' or display_name LIKE '%".$search."%' or display_name LIKE '".$search."%'  or display_name LIKE '".$search."'";

                $result = $connection->query($query);

                if($result->num_rows>0){
                    $places = array();


                    while ($row = $result->fetch_assoc()) {
                        $placeLatitude = $row['latitude'];
                        $placeLongitude = $row['longitude'];

                        $distance = haversine($userLatitude, $userLongitude, $placeLatitude, $placeLongitude);

                        $places[] = array(
                            'nome' => $row['display_name'],
                            'distancia' => $distance,
                            'id' => $row['id'],
                            'address' => $row['address']
                        );
                    }
                    usort($places, function ($a, $b) {
                        return $a['distancia'] - $b['distancia'];
                    });

                    echo '<h1 style="color:white">Resultados da sua busca:</h1><bR><div class="search_results d-flex align-items-center flex-column">';
                    foreach ($places as $place) {
                        ?>
                            <a href="/m/search?id=<?=$place["id"]?>" style="color:white;">
                                <div class="place_result d-flex align-items-center flex-column">
                                    <span class="place_result_name"><?=$place["nome"]?></span>
                                    <span class="place_result_addr"><?=$place["address"]?></span>
                                    <span class="place_result_distance"><?=round($place["distancia"],1)?> km</span>
                                </div>
                            </a>

                        <?php
                    }
                    echo '</div>';
                }else{
                    echo '<div class="p-3"><div class="alert alert-danger" role="alert">Não foi encontrado nada para sua busca.</div></div>';
                }

}else{
    //SEARCH HOME

    ?>

        <div class="body_search d-flex justify-content-center align-items-center " style="height:30%;width:100% ">
            <form action="/m/search" method="GET" class="signin-form mb-3" data-bitwarden-watching="1" >
                <div class="d-inline-flex" >
                    <div class="col-auto my-1">
                        <input type="text" name="s" class="form-control  bg-dark text-white" placeholder="Pesquisa" style="border:none;width:100%">
                        <input type="hidden" id="user_lat" name="user_lat">
                        <input type="hidden" id="user_lon" name="user_lon">
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-dark">OK</button>
                    </div>
                </div>
            </form>
        </div>


        <script>

            if ("geolocation" in navigator) {
                // Obtém a geolocalização do usuário
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;


                    document.getElementById("user_lat").value = latitude;
                    document.getElementById("user_lon").value = longitude;

                    console.log(latitude + " | "+ longitude);
                }, function(error){
                    window.location.href = "/m?error=Serviço indisponível: Não foi possível obter a sua geolocalização, aprove a notificação solicitada ou altere nas configurações do seu telefone.";


                });
            } else {
                window.location.href = "/m?error=Serviço indisponível: Não foi possível obter a sua geolocalização, aprove a notificação solicitada ou altere nas configurações do seu telefone.";

            }
        </script>
    <?php
}


?>











<div class="debug"></div>

<div class="navbar_bottom">
    <div class="d-flex justify-content-center align-items-center navbar_med">
        <div class="col-xs-1 navbar_item">
            <a href="/m/"><img src="../assets/img/home_off.png" class="navbar_img" /></a>
        </div>
        <div class="col-xs-1 navbar_item">
            <a href="/m/search"><img src="../assets/img/search_on.png" class="navbar_img" /></a>
        </div>
        <div class="col-xs-1 navbar_item">
            <a href="/m/profile"><img src="../assets/img/profile_off.png" class="navbar_img" /></a>
        </div>
    </div>
</div>


</body>
</html>

