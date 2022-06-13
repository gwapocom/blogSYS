<?php require_once "includes/DB.php"; ?>
<?php require_once "includes/functions.php"; ?>
<?php require_once "includes/sessions.php"; ?>

<?php $_SESSION['TrackingURL']= $_SERVER["PHP_SELF"]; ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <title>Posts</title>
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
                  <a href="comment.php" class="nav-link">Comments</a>
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
               <h1><i class="fa-solid fa-blog" style="color:27aae1;"></i> Blog Posts</h1>
            </div>
            <div class="col-lg-3 mb-2">
               <a class="btn btn-primary btn-block" href="addnewpost.php"><i class="fa-solid fa-edit"></i>Add New Post</a>
            </div>

            <div class="col-lg-3 mb-2">
               <a class="btn btn-info btn-block" href="categories.php"><i class="fa-solid fa-folder-plus"></i>Add New Category </a>
            </div>
            <div class="col-lg-3 mb-2">
               <a class="btn btn-warning btn-block" href="admin.php"><i class="fa-solid fa-user-plus"></i>Add New Admin</a>
            </div>
            <div class="col-lg-3">
               <a class="btn btn-success btn-block" href="comment.php"><i class="fa-solid fa-check"></i> Approve Comments</a>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <!-- Main Area -->
   <section class="container py-2 mb-4">
      <div class="row">
         <div class="col-lg-12">
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
            ?>
            <table class="table table-striped table-hover">
               <thead class="thead-dark">
                  <tr>
                     <th>#</th>
                     <th>Title</th>
                     <th>Category</th>
                     <th>Date&Time</th>
                     <th>Author</th>
                     <th>Banner</th>
                     <th>Comments</th>
                     <th>Action</th>
                     <th>Live Preview</th>
                  </tr>
               </thead>
               <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts";
                  $stmt = $ConnectingDB->query($sql);
                  $Sr = 0;
                  while ($DataRows = $stmt->fetch()) {
                     $Id = $DataRows["id"];
                     $DateTime = $DataRows["datetime"];
                     $PostTitle = $DataRows["title"];
                     $Category = $DataRows["category"];
                     $Admin = $DataRows["author"];
                     $Image = $DataRows["image"];
                     $PostText = $DataRows["post"];
                     $Sr++;
                  ?>
               <tbody>
                  <tr>
                     <td><?php echo $Sr; ?></td>
                     <td>
                        <?php if(strlen($PostTitle)>20){$PostTitle=substr($PostTitle,0,18).'..';}
                           echo $PostTitle; ?></td>
                     <td>
                        <?php 
                           if(strlen($Category)>8){$Category=substr($Category,0,8).'..';}
                           echo $Category; ?> </td>
                     <td>
                        <?php 
                           if(strlen($DateTime)>11){$DateTime=substr($DateTime,0,11).'..';}
                           echo $DateTime; ?> </td>
                     <td><?php 
                           if(strlen($Admin)>6){$Admin=substr($Admin,0,6).'..';}
                           echo $Admin; ?></td>
                     <td>
                        <img src="uploads/<?php echo $Image; ?>" width="170px;" height="50px;""</td>
                     <td>Comments</td>
                     <td>
                        <a href="editpost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                        <a href="deletepost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                     </td>
                     <td>
                        <a href="fullpost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                     </td>
                  </tr>
               </tbody>
               <?php
                     } ?>
            </table>
         </div>
      </div>
   </section>
   <!-- Main Area END -->
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
