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
            if(isset($_GET["error"])){
                echo '<div class="p-3"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
            }

            if(isset($_GET["msg"])){
                echo '<div class="p-3"><div class="alert alert-info" role="alert">'.$_GET['msg'].'</div></div>';
            }
            ?>

            <h1>Creating new location</h1>
            <form action="location_create.php" method="POST">
                <div class="info d-flex flex-row">
                    <div class="p-2">
                        <h5>Display name: </h5>
                    </div>
                    <div class="p-2">
                        <input type="text" name="display_name" required="" value="<?php if(isset($_GET['pre_name'])){echo $_GET['pre_name'];} ?>" style="width:50vw;"/>
                    </div>
                </div>
                <div class="info d-flex flex-row">
                    <div class="p-2">
                        <h5>Location: </h5>
                    </div>
                    <div class="p-2">
                        Lat: <input type="text" required="" id="lat" name="lat" value="<?php if(isset($_GET['pre_lat'])){echo $_GET['pre_lat'];} ?>" style="width:20vw;"/>
                    </div>
                    <div class="p-2">
                        Lon: <input type="text" required="" id="lon" name="lon" value="<?php if(isset($_GET['pre_lon'])){echo $_GET['pre_lon'];} ?>" style="width:20vw;"/>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-dark btn-sm" style="height:30px" onclick='window.open("https://www.google.com/maps/?q="+document.getElementById("lat").value+","+document.getElementById("lon").value, "_blank");'>Open on Maps</button>
                    </div>
                </div>
                <div class="info d-flex flex-row">
                    <div class="p-2">
                        <h5>Address: </h5>
                    </div>
                    <div class="p-2">
                        <input type="text" name="address" required="" value="" style="width:30vw;"/>
                    </div>
                </div>
                <div class="info d-flex flex-row">
                    <div class="p-2">
                        <h5>CEP: </h5>
                    </div>
                    <div class="p-2">
                        <input type="text" name="cep" required="" value="" style="width:30vw;"/>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Create</button>

            </form>
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
