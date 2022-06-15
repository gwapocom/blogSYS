<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<!-- Fetch Existing Data -->
<?php 
   $SearchQueryParameter=$_GET['username'];
   global $ConnectingDB;
   $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userNem";
   $stmt=$ConnectingDB->prepare($sql);
   $stmt->bindValue(':userNem', $SearchQueryParameter);
   $stmt->execute();
   $Result=$stmt->rowCount();
   if ($Result==1) {
      while ($DataRows=$stmt->fetch()) {
         $ExistingName=$DataRows["aname"];
         $ExistingBio=$DataRows["abio"];
         $ExistingImage=$DataRows["aimage"];
         $ExistingHeadline=$DataRows["aheadline"];
   }   
   }else {
      $_SESSION['ErrorMessage']="Bad Request !!";
      Redirect_to("blog.php?page=1");
   }
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <title>Profile</title>
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
   <header class="bg-dark text-white py-3">
      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <h1><i class="fa-solid fa-user text-success mr-2" style="color:27aae1;"></i> <?php echo $ExistingName; ?></h1>
               <h3><?php echo $ExistingHeadline; ?></h3>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <section class="container py-2 mb-4">
      <div class="row">
         <div class="col-md-3"><img src="img/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt=""></div>

         <div class="col-md-9" style="min-height: 400px;">
            <div class="card">
               <div class="card-body">
                  <p class="lead"><?php echo $ExistingBio; ?></p>
               </div>
            </div>
         </div>
      </div>
   </section>
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
