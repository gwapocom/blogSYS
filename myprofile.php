<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $_SESSION['TrackingURL']= $_SERVER["PHP_SELF"]; ?>
<?php Confirm_Login(); ?>
<?php 

   $AdminID=$_SESSION['User_ID'];
   global $ConnectingDB;
   $sql="SELECT * FROM admins WHERE id='$AdminID'";
   $stmt=$ConnectingDB->query($sql);
   while ($DataRows=$stmt->fetch()) {
      $ExistingName=$DataRows['aname'];
      $ExistingUsername=$DataRows['username'];
      $ExistingHeadline=$DataRows['aheadline'];
      $ExistingBio=$DataRows['abio'];
      $ExistingImage=$DataRows['aimage'];
   }

if(isset($_POST['Submit'])){
   $AName = $_POST['name'];
   $AHeadline = $_POST['headline'];
   $ABio = $_POST['bio'];
   $Image = $_FILES['image']['name'];
   $Target = "img/".basename($_FILES['image']['name']);

   if (strlen($AHeadline)>30) {
      $_SESSION['ErrorMessage'] = "Headline should be less than 30 characters";
    Redirect_to("myprofile.php");   
 }elseif (strlen($ABio)>500) {
    $_SESSION['ErrorMessage'] = "Post description should be less than 1000 characters";
    Redirect_to("myprofile.php");   
    }else{
       //Query to update Admin Data in DB when fine 
       global $ConnectingDB;
       if (!empty($_FILES["image"]["name"])) {
          $sql = "UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image' WHERE id='$AdminID'";
       }else {
          $sql = "UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio' WHERE id='$AdminID'";
       }
       $Execute = $ConnectingDB->query($sql);
      move_uploaded_file($_FILES['image']["tmp_name"],$Target);

      if($Execute) {
         $_SESSION['SuccessMessage']="Details Updated Successfully";
         Redirect_to("myprofile.php");
      } else {
         $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("myprofile.php");
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
   <title>Add New Post</title>
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
                  <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user"></i> My Profile</a>
               </li>
               <li class="nav-item">
                  <a href="Dashboard.php" class="nav-link">Dashboard</a>
               </li>
               <li class="nav-item">
                  <a href="poset.php" class="nav-link">Posts</a>
               </li>
               <li class="nav-item">
                  <a href="categories.php" class="nav-link">Categories</a>
               </li>
               <li class="nav-item">
                  <a href="admin.php" class="nav-link">Manage Admins</a>
               </li>
               <li class="nav-item">
                  <a href="comments.php" class="nav-link">Comments</a>
               </li>
               <li class="nav-item">
                  <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
               </li>
            </ul>
            <ul class="navbar-nav ml-auto">
               <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"> <i class="fa-solid fa-user-times"></i> Logout</a></li>
            </ul>
         </div>
      </div>
   </nav>

   <div style="height:10px; background:#27aae1"></div>
   <!-- NAVBAR END -->
   <!-- HEADER -->
   <header class="bg-dark text-white py-3">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <h1><i class="fa-solid fa-user mr-2" style="color:27aae1;"></i>@<?php echo $ExistingUsername; ?></h1>
               <small><?php echo $ExistingHeadline; ?></small>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <!-- Main Area -->
   <section class="container py-2 mb-4">
      <div class="row">
         <!-- Left Area -->
         <div class="col-md-3">
            <div class="card">
               <div class="card-header bg-dark text-light">
               <h3><?php echo $ExistingName; ?></h3>
               </div>
               <div class="card-body">
                  <img src="img/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
                  <div class="u">
                     <?php echo $ExistingBio; ?>
                  </div>
               </div>
            </div>
         </div>
         <!-- Right Area -->
         <div class="col-md-9" style="min-height:400px;">
            <?php 
                 echo ErrorMessage();
                 echo SuccessMessage();
                ?>
                <form class="" action="myprofile.php" method="post" enctype="multipart/form-data">
                   <div class="card bg-dark text-light">
                      <div class="card-header bg-secondary text-light">
                     <h4>Edit Profile</h4>
                  </div>
                  <div class="card-body">
                     <div class="form-group">
                        <input class="form-control" type="text" name="name" id="title" placeholder="Your Name" value="">
                     </div>

                     <div class="form-group">
                        <input class="form-control" type="text" name="headline" id="title" placeholder="Headline" value="">
                        <small class="text-muted">Add a professional headline like, "Engineer" at XYZ</small>
                        <span class="text-danger">Not more than 30 characters</span>
                     </div>

                     <div class="form-group">
                        <textarea placeholder="bio" id="post" class="form-control" name="bio" cols="80" rows="8"></textarea>
                     </div>

                     <div class="form-group">
                        <div class="custom-file">
                           <input class="custom-file-input" type="file" name="image" id="imageSelect" value="">
                           <label for="imageSelect" class="custom-file-label">Select Image</label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6 mt-3">
                           <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                        </div>
                        <div class="col-lg-6 mt-3">
                           <button type="submit" name="Submit" class="btn btn-success btn-block">
                              <i class="fas fa-check"></i>
                              Publish
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         </form>
      </div>
      </div>
   </section>



   <!-- Main END -->
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
