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
   <title>Dashboard</title>
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
               <h1><i class="fa-solid fa-cog" style="color:27aae1;"></i>Dashboard</h1>
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
         
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
            ?>
            <!-- Left side start -->
            <div class="col-lg-2">
               <div class="card text-center bg-dark text-white mb-3">
                  <div class="card-body">
                     <h1 class="lead">Posts</h1>
                     <h4 class="display-5"><i class="fa-brands fa-readme"></i> 
                        <?php 
                           TotalPosts();
                        ?>
                     </h4>
                  </div>

                  <div class="card-body">
                     <h1 class="lead">Categories</h1>
                     <h4 class="display-5"><i class="fa-solid fa-folder"></i> 
                        <?php
                           TotalCategory();
                        ?>
                     </h4>
                  </div>

                  <div class="card-body">
                     <h1 class="lead">Admins</h1>
                     <h4 class="display-5"><i class="fa-solid fa-users"></i> 
                        <?php 
                           TotalAdmin();
                        ?>
                     </h4>
                  </div>

                  <div class="card-body">
                     <h1 class="lead">Comments</h1>
                     <h4 class="display-5"><i class="fa-solid fa-comments"></i> 
                        <?php 
                           TotalComment();
                        ?>
                     </h4>
                  </div>
               </div>
            </div>
         <!-- Left side end -->
            
           <div class="col-lg-10">
               <h1>Top Posts</h1>
               <table class="table table-striped table-hover">
                  <thead class="thead-dark">
                     <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Details</th>
                     </tr>
                  </thead>
                  <?php
                     $SrNo=0;
                     $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                     $stmt=$ConnectingDB->query($sql);
                     while ($DataRows=$stmt->fetch()) {
                        $PostID=$DataRows["id"];
                        $DateTime=$DataRows["datetime"];
                        $Author=$DataRows["author"];
                        $Title=$DataRows["title"];
                        $SrNo++;
                  ?>
                     <tbody>
                        <tr>
                           <td><?php echo $SrNo; ?></td>
                           <td><?php echo $Title; ?></td>
                           <td><?php echo $DateTime; ?></td>
                           <td><?php echo $Author; ?></td>
                           <td>
                                 <?php
                                    $Total = AppCommAccPos($PostID);
                                    if ($Total>0) {
                                    ?>
                                       <span class="badge badge-success">
                                       <?php echo $Total; ?>
                                       </span>
                                       
                                       <?php } ?>

                                 <?php
                                    $Total = DisAppCommAccPos($PostID);
                                    if ($Total>0) {
                                    ?>
                                       <span class="badge badge-danger">
                                       <?php echo $Total; ?>
                                       </span>
                                       
                                       <?php } ?>

                           </td>

                           <td><a target="_blank" href="FullPost.php?id=<?php echo $PostID; ?>"><span class="btn btn-info">Preview</span></a></td>
                        </tr>
                     </tbody>
                     <?php } ?>
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
