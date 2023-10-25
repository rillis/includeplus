<?php
$root = "../../";
include($root.'functions/validate_login.php');

if (!isLogged("pc")){
    //session_start();
  header('Location: /pc/admin/login');
}



function getDBToTable($query, $multarray, $type){
    global $root;
    include($root.'functions/connect.php');

  $s = '<table id="DataTable" class="display" style="width:75vw;"><thead><tr>';
  foreach (array_keys($multarray) as $key) {
    $s = $s . '<th>'.$key.'</th>';
  }
  $s = $s . '<th>GoTo</th></tr></thead><tbody>';
  $result = $connection->query($query);
  foreach($result as $row) {
    $s = $s . '<tr>';
      foreach ($multarray as $key => $value) {
        $s = $s . '<td>'.$row[$value].'</td>';
      }
    $s = $s . '<td><a href="/pc/admin/details.php?type='.$type.'&id='.$row['id'].'">Details</a></td></tr>';
  }
  $s = $s . '</tbody></table>';
  return $s;
}

function totalPending($text, $table, $link){
    global $root;
    include($root.'functions/connect.php');
  $query = "SELECT count(*) as cnt from ".$table;
  $result = $connection->query($query);
  $row = $result->fetch_assoc();
  return '<br><span class="pending_count">'.$text.': '.$row["cnt"].'</span> <a href="/pc/admin?page='.$link.'">></a>';
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
        <div class="content d-flex align-items-start flex-wrap" style="">
          <?php
            //no page
            if(!isset($_GET["page"])){
              ?>
              <div class="non-page">
                <span class="hello">Hello, <?php echo $_SESSION['user']." (ID ".$_SESSION['id'].")" ?>.</span><br>

                  <?php
                  if(isset($_GET["error"])){
                      echo '<div class="p-3"><div class="alert alert-danger" role="alert">'.$_GET['error'].'</div></div>';
                  }

                  if(isset($_GET["msg"])){
                      echo '<div class="p-3"><div class="alert alert-info" role="alert">'.$_GET['msg'].'</div></div>';
                  }
                  ?>

                <?php
                echo totalPending("Pending posts", "vw_pending_posts", "pending_posts");
                echo totalPending("Pending removals", "vw_pending_removals", "pending_removals");
                ?>
              </div>
              <?php
                }else if($_GET['page'] === "pending_posts"){
                  $arr = ["ID" => "id", "Place ID" => "place_id", "User" => "user", "Title" => "title", "Create Time" => "created_at"];
                  $query = "SELECT a.*, b.name, b.user FROM vw_pending_posts a LEFT JOIN users b ON a.user_id = b.id";
                  echo getDBToTable($query, $arr, "pending_posts");
                }else if($_GET['page'] === "pending_removals"){
                  $arr = ["ID" => "id", "Post ID" => "post_id", "User" => "user", "Title" => "title", "Create Time" => "created_at"];
                  $query = "SELECT a.*, b.name, b.user FROM vw_pending_removals a LEFT JOIN users b ON a.user_id = b.id";
                  echo getDBToTable($query, $arr, "pending_removals");
                }else if($_GET['page'] === "posts"){
                  $arr = ["ID" => "id", "Place ID" => "place_id", "User" => "user", "Title" => "title", "Create Time" => "created_at", "Approved By" => "approved_by_user"];
                  $query = "SELECT a.*, b.name, b.user, c.user as approved_by_user FROM posts a LEFT JOIN users b ON a.user_id = b.id LEFT JOIN users c ON a.approved_by = c.id";
                  echo getDBToTable($query, $arr, "posts");
                }else{
                  header('Location: /pc/admin');
                }
              ?>
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
