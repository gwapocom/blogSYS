<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $SearchQueryParameter = $_GET['id']; ?>
<?php 
   if(isset($_POST['submit'])){
   $CommenterName = $_POST['commentername'];
   $CommenterEmail = $_POST['commenteremail'];
   $Commenter = $_POST['commenterthoughts'];

date_default_timezone_set("Asia/Karachi");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

         if(empty($CommenterName)||empty($CommenterEmail)||empty($Commenter)) {
            $_SESSION['ErrorMessage'] = "All fields must be filled out";
            Redirect_to("fullpost.php?id={$SearchQueryParameter}");   
         }elseif (strlen($Commenter)>500) {
            $_SESSION['ErrorMessage'] = "Comment length should be less than five hundred characters";
            Redirect_to("fullpost.php?id={$SearchQueryParameter}");   
         }else{
            //Query to insert comment in DB when fine 
            $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
            $sql .="VALUES(:datetime,:name,:email,:comment,'pending','OFF',:postIDfromURL)";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':datetime',$DateTime);
            $stmt->bindValue(':name',$CommenterName);
            $stmt->bindValue(':email',$CommenterEmail);
            $stmt->bindValue(':comment',$Commenter);
            $stmt->bindValue(':postIDfromURL',$SearchQueryParameter);
      $Execute=$stmt->execute();
/* var_dump($Execute); */
      if ($Execute) {
         $_SESSION['SuccessMessage']="Comment submitted successfully";
            Redirect_to("fullpost.php?id={$SearchQueryParameter}");   
      } else {
         $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
            Redirect_to("fullpost.php?id={$SearchQueryParameter}");   
      }
    }
 } //Ending of Submit Button If-Condition
 ?>
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
    <div style="height:10px; background:#27aae1;"></div>


    
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
                      /* Default sql query */
                      $PostIdFromURL = $_GET["id"];
                      if (!isset($PostIdFromURL)) {
                         $_SESSION["ErrorMessage"]="Bad Request!";
                         Redirect_to("blog.php");
                      }
                      $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
                      $stmt = $ConnectingDB->query($sql);
                      $Result=$stmt->rowCount();
                      if ($Result!=1) {
                         $_SESSION['ErrorMessage']="Bad Request !";
                         Redirect_to("Blog.php?page=1");
                      }
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
                   <hr>
                   <p class="card-text">
                   <?php 
                      echo nl2br($PostText); 
                      //
                   ?>
                   </p>
                </div>
             </div>

             <?php } ?>
             <span class="FieldInfo">Comments</span>
             <br>
             <br>
             <!-- comment part start-->
             <!-- fetching existing comment start -->
             <?php 
                      global $ConnectingDB; 
                      $sql = "SELECT * FROM comments 
                      WHERE post_id='$SearchQueryParameter' AND status='ON'";
                      $stmt = $ConnectingDB->query($sql);
                      while ($DataRows=$stmt->fetch()) {
                         $CommentDate = $DataRows['datetime'];
                         $CommentName = $DataRows['name'];
                         $CommentContent = $DataRows['comment'];
             ?>
             <div>
                <div class="media COCK">
                   <img class="d-block img-fluid" src="img/comment.png" alt="">
                   <div class="media-body ml-2">
                      <h6 class="lead"><?php echo $CommentName; ?></h6>
                      <p class="small"><?php echo $CommentDate; ?></p>
                      <p><?php echo $CommentContent; ?></p>
                   </div>
                </div>
             </div>
             <hr>
             
             <?php } ?>
             <!-- fetching existing comment end -->
             <div class="">
                <form class="u" action="fullpost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                   <div class="card mb-3">
                      <div class="card-header">
                         <h5 class="FieldInfo">Share your thoughts about this post</h5>
                      </div>
                      <div class="card-body">
                         <div class="form-group">
                            <div class="input-group">
                               <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                               </div>
                               <input class="form-control" type="text" name="commentername" placeholder="name" value="">
                               
                            </div>
                         </div>

                         <div class="form-group">
                            <div class="input-group">
                               <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                               </div>
                               <input class="form-control" type="email" name="commenteremail" placeholder="email" value="">
                               
                            </div>
                         </div>
                         <div class="form-group">
                            <textarea class="form-control" name="commenterthoughts" cols="80" rows="6"></textarea>
                         </div>
                         <div class="">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                         </div>
                      </div>
                   </div>
                </form>
             </div>
          </div>
          <!-- Main Area End */-->
          <!-- /* Side Area Start */ -->
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
          <!-- /* Side Area End */ -->
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
