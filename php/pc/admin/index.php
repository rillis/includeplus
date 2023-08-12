<?php
include('login/validate_login.php');

if (!isLogged()){
  header('Location: /pc/admin/login');
}

include('../../functions/connect.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <script src='../../scripts/ensureViewPort.js'></script> 
    <script>
      if(window.mobileCheck()){
        window.location.href = "/m";
      }
    </script>
    <meta charset="utf-8">
    <title>Include+</title>

    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/admin_panel.css" rel="stylesheet" />
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
            if(!isset($_GET["page"])){
              ?>
              <div class="non-page">
                <span class="hello">Hello, <?php echo $_SESSION['user']." (ID ".$_SESSION['id'].")" ?>.</span><br>

                <?php
                $query = "SELECT count(*) as cnt from vw_pending_posts";
                $result = $connection->query($query);
                $row = $result->fetch_assoc();
                echo '<br><span class="pending_count">Pending posts: '.$row["cnt"].'</span> <a href="/pc/admin?page=pending_posts">></a>';
                $query = "SELECT count(*) as cnt from vw_pending_removals";
                $result = $connection->query($query);
                $row = $result->fetch_assoc();
                echo '<br><span class="pending_count">Pending removals: '.$row["cnt"].'</span> <a href="/pc/admin?page=pending_removals">></a>';
                ?>
              </div>
              <?php
              $stmt->close();
            }
          ?>
        </div>
      </div>



  </body>
</html>
