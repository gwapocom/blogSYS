<?php require_once "includes/DB.php"; ?>
<?php require_once "includes/functions.php"; ?>
<?php require_once "includes/sessions.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Blog</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/8e45f7668c.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">JAZEBAKRAM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS"><span class="navbar-toggler-icon"></span></button>
            <div id="navbarcollapseCMS" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                    <a href="blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">About us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                   <form class="form-inline d-none d-sm-block" action="blog.php">
                   <div class="form-group">
                      <input class="form-control mr-2" type="text" name="search" placeholder="type here" value="">
                      <button  class="btn btn-primary" name="searchbutton" >Search</button>
                   </div>
                </form>
                </ul>
            </div>
        </div>
    </nav>

    <div style="height:10px; background:#27aae1"></div>
    
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <div class="container">
       <div class="row mt-4">
          <div class="col-sm-8">
             <h1>The Complete Responsive CMS Blog</h1>
             <h1 class="lead">The Complete blog by using PHP by ME</h1>
             <?php 
                echo ErrorMessage(); 
                echo SuccessMessage(); 
             ?>
             <?php 
                global $ConnectingDB;
                if (isset($_GET["searchbutton"])) {
                   $Search = $_GET['search'];
                   $sql = "SELECT * FROM posts 
                   WHERE datetime LIKE :search 
                   OR title LIKE :search 
                   OR category LIKE :search
                   ";
                   $stmt = $ConnectingDB->prepare($sql);
                   $stmt->bindValue(':search','%'.$Search."%");
                   $stmt->execute();
                   }else {
                      $sql = "SELECT * FROM posts ORDER BY id DESC";
                      $stmt = $ConnectingDB->query($sql);
                   }
               while ($DataRows = $stmt->fetch()) {
                  $PostId = $DataRows["id"];
                  $DateTime = $DataRows["datetime"];
                  $PostTitle = $DataRows["title"];
                  $Category = $DataRows["category"];
                  $Admin = $DataRows["author"];
                  $Image = $DataRows["image"];
                  $PostText = $DataRows["post"];
             ?>
             <div class="card">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height: 450px;" class="img-fluid card-img-top" alt="">
                <div class="card-body">
                   <h4 class="card-title">
                      <?php echo $PostTitle; ?>
                   </h4>
                   <small class="text-muted">Written by <?php echo htmlentities($Admin); ?> On <?php echo htmlentities($DateTime); ?></small>
                   <span style="float: right;" class="badge badge-dark text-light">Comments 20</span>
                   <hr>
                   <p class="card-text">
                   <?php 
                      if (strlen($PostText)>150) {
                         $PostText = substr($PostText,0,150)."...";
                      }
                      echo htmlentities($PostText); ?></p>
                      <a href="fullpost.php?id=<?php echo $PostId; ?>" style="float: right;">
                      <span class="btn btn-info">Read More >></span>
                   </a>
                </div>
             </div>
             <?php } ?>
          </div>
          <div class="col-sm-4" style="min-height: 40px; background: green;">
          </div>
       </div>
    </div>
    <!-- HEADER END -->
    <br>
    <!-- FOOTER -->
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | ME | Copyright <span id="year"></span> All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height:10px; background:#27aae1"></div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>





</html>
