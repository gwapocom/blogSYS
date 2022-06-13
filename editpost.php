<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php Confirm_Login(); ?>
<?php 
   $SearchQueryParameter = $_GET['id'];
if(isset($_POST['Submit'])){
   $PostTitle = $_POST['postitle'];
   $Category = $_POST['categorry'];
   $Image = $_FILES['image']['name'];
   $Target = "uploads/".basename($_FILES['image']['name']);
   $PostText = $_POST['postdescription'];
$Admin = "OTIN";

date_default_timezone_set("Asia/Karachi");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
         echo $DateTime;
if(empty($PostTitle)) {
   $_SESSION['ErrorMessage'] = "Title can't be empty";
   Redirect_to("poset.php");   
}elseif (strlen($PostTitle)<5) {
   $_SESSION['ErrorMessage'] = "Post title should be greater than 5 characters";
    Redirect_to("poset.php");   
 }elseif (strlen($PostText)>9999) {
    $_SESSION['ErrorMessage'] = "Post description should be less than 1000 characters";
    Redirect_to("poset.php");   
    }else{
       //Query to update Post in DB when fine 
       global $ConnectingDB;
       if (!empty($_FILES["image"]["name"])) {
          $sql = "UPDATE posts SET title='$PostTitle', category='$Category', image='$Image', post='$PostText' WHERE id='$SearchQueryParameter'";
       }else {
          $sql = "UPDATE posts SET title='$PostTitle', category='$Category', post='$PostText' WHERE id='$SearchQueryParameter'";
       }
       $Execute = $ConnectingDB->query($sql);
      move_uploaded_file($_FILES['image']["tmp_name"],$Target);
      if($Execute) {
         $_SESSION['SuccessMessage']="Post with id : ".$ConnectingDB->lastInsertId()." Added Successfully";
         Redirect_to("poset.php");
      } else {
         $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("poset.php");
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
   <link rel="stylesheet" href="css/styles.css">
   <title>Edit Post</title>
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
                  <a href="Posts.php" class="nav-link">Posts</a>
               </li>
               <li class="nav-item">
                  <a href="Categories.php" class="nav-link">Categories</a>
               </li>
               <li class="nav-item">
                  <a href="Admins.php" class="nav-link">Manage Admins</a>
               </li>
               <li class="nav-item">
                  <a href="Comments.php" class="nav-link">Comments</a>
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
               <h1><i class="fa-solid fa-edit" style="color:27aae1;"></i>Edit Post</h1>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <!-- Main Area -->
   <section class="container py-2 mb-4">
      <div class="row">
         <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
            <?php 
                 echo ErrorMessage();
                 echo SuccessMessage();
                 //Fetching Existing content in DB
                 global $ConnectingDB;
                 $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
                 $stmt = $ConnectingDB->query($sql);
                 while ($DataRows = $stmt->fetch()) {
                    $TitleToUpdate = $DataRows["title"];
                    $CategoryToUpdate = $DataRows["category"];
                    $ImageToUpdate = $DataRows["image"];
                    $PostTextToUpdate = $DataRows["post"];
                 }
                ?>
                <form class="" action="editpost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
               <div class="card bg-secondary text-light mb-3">
                  <div class="card-body bg-dark">
                     <div class="form-group">
                        <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
                        <input class="form-control" type="text" name="postitle" id="title" placeholder="Type title here" value="<?php echo $TitleToUpdate; ?>">
                     </div>

                     <div class="form-group">
                        <span class="FieldInfo">Existing Category: </span>
                        <?php echo $CategoryToUpdate; ?>
                        <label for="categorytitle"> <span class="FieldInfo"> Choose Category Title: </span></label>
                        <select id="categorytitle" class="form-control" name="categorry">
                           <?php
                              //Fetching all the categories from category table  
                            global $ConnectingDB;
                           $sql = "SELECT * FROM category";
                           $stmt = $ConnectingDB->query($sql);
                           while ($DataRows = $stmt->fetch()) {
                              $Id = $DataRows['id'];
                              $CategoryName = $DataRows['title'];
                           ?>
                           <option><?php echo $CategoryName; ?></option>
                           <?php } ?>
                       </select>
                     </div>
                     <div class="form-group">
                        <span class="FieldInfo">Existing Image: </span>
                        <img class="mb-2" src="uploads/<?php echo $ImageToUpdate; ?>" width="170px"; height="70px"; alt="">
                        <div class="custom-file">
                           <input class="custom-file-input" type="file" name="image" id="imageSelect" value="">
                           <label for="imageSelect" class="custom-file-label">Select Image</label>
                        </div>
                     </div>
                     <div class="form-group">

                        <label for="post"> <span class="FieldInfo"> Post: </span></label>
                        <textarea id="post" class="form-control" name="postdescription" cols="80" rows="8">
                           <?php echo $PostTextToUpdate; ?>
                        </textarea>
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
