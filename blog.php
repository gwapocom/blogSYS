<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
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
   <style>
      .heading {
         font-family: Bitter, Georgia, "Times New Roman", Times, serif;
         font-weight: bold;
         color: #005E90;
      }

      .heading:hover {
         color: #0090DB;
      }
   </style>
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
                     <button class="btn btn-primary" name="searchbutton">Search</button>
                  </div>
               </form>
            </ul>
         </div>
      </div>
   </nav>
   ;
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
                   //Query when pagination is active i.e. Blog.php?Page=1
                }elseif (isset($_GET['page'])){
                   $Page=$_GET['page'];
                   if($Page==0||$Page<1){
                      $ShowPostFrom=0;
                   }else{
                      $ShowPostFrom=($Page*4)-4;
                   }
                   $sql="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4"; 
                   $stmt=$ConnectingDB->query($sql);
                   }
                   //Query when Category is aactive in URL tab
                   elseif (isset($_GET['category'])){
                      $Category=$_GET['category'];
                      $sql="SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                      $stmt=$ConnectingDB->query($sql);
                   }
                   //the default sql query
                else {
                   $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,3";
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
                  <small class="text-muted">Category: <span class="text-dark"><a href="blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> & Written by <span class="text-dark"><a href="profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a></span> On <?php echo htmlentities($DateTime); ?></small>
                  <span style="float: right;" class="badge badge-dark text-light">Comments <?php echo  AppCommAccPos($PostId); ?></span>
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
            <!-- Pagination -->
            <nav>
               <ul class="pagination pagination-lg">
                  <!-- Creating Forward Button -->
                  <?php if (isset($Page)) {
                        if ($Page>1) {
                   ?>
                  <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $Page-1; ?>">&laquo;</a></li>
                  <?php } } ?>
                  <?php
                     $sql="SELECT COUNT(*) FROM posts";
                     $stmt=$ConnectingDB->query($sql);
                     $RowPagination=$stmt->fetch();
                     $TotalPosts=array_shift($RowPagination);
                     $PostPagination=$TotalPosts/4;
                     $PostPagination=ceil($PostPagination);
                     for ($i = 1; $i <= $PostPagination; $i++) {
                        if(isset($Page)){ 
                           if ($i==$Page) { ?>
                  <li class="page-item active"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php
                  }else {
                  ?>
                  <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                  <?php  } } } ?>
                  <!-- Creating Forward Button -->
                  <?php if (isset($Page) && !empty($Page)) {
                        if ($Page+1<=$PostPagination) {
                   ?>
                  <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $Page+1; ?>">&raquo;</a></li>
                  <?php } } ?>
               </ul>
            </nav>
         </div>
         <!-- Main Area end -->

         <!-- Side Area start -->
         <div class="col-sm-4">
            <div class="card mt-4">
               <div class="card-body"><img src="img/start.png" class="d-block img-fluid mb-3" alt=""></div>
               <div class="text-center">
                  Amet aperiam sed sapiente aspernatur consequuntur id atque nihil, hic, exercitationem Quod facilis natus nisi numquam nesciunt Nemo at commodi hic aspernatur at? Eveniet distinctio labore quo culpa quas Laboriosam?
               </div>
            </div>
            <br>
            <div class="card">
               <div class="card-header bg-dark text-light">
                  <h2 class="lead">Sign Up !</h2>
               </div>

               <div class="card-body">
                  <button class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
                  <button class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                  <div class="input-group mb-3">
                     <input class="form-control" type="text" name="" placeholder="Enter your email" value="">
                     <div class="input-group-append">
                        <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                     </div>
                  </div>
               </div>
            </div>
            <br>
            <div class="card">
               <div class="card-header bg-primary text-light">
               <h2 class="lead">Categories</h2>
            </div>
            <div class="card-body">
               <?php 
                  global $ConnectingDB;
                  $sql = "SELECT * FROM category ORDER BY id desc";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows=$stmt->fetch()) {
                     $CategoryID = $DataRows['id'];
                     $CategoryName = $DataRows['title'];
                  ?>
                  <a href="blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a> <br>
                  <?php } ?> 
               </div>
            </div>
            <br>
            <div class="card-header bg-info text-white">
               <h2 class="lead">Recent Posts</h2>
            </div>

            <div class="card-body">
               <?php
                  global $ConnectingDB;
                  $sql="SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                  $stmt=$ConnectingDB->query($sql);
                  while ($DataRows=$stmt->fetch()) {
                     $ID=$DataRows['id'];
                     $Title=$DataRows['title'];
                     $DateTime=$DataRows['datetime'];
                     $Image=$DataRows['image'];

               ?>
               <div class="media">
                  <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                  <div class="media-body ml-2">
                     <a href="fullpost.php?id=<?php echo $ID; ?>" target="_blank"><h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
                     <p class="small"><?php echo htmlentities($DateTime); ?></p>
                  </div>
               </div>
               <hr>
               
               <?php } ?> 
            </div>
         </div>
      </div>
      <!-- Side Area END -->
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
