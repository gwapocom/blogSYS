<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $_SESSION['TrackingURL']= $_SERVER["PHP_SELF"]; ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <title>Comment</title>
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
               <h1><i class="fa-solid fa-comments" style="color:27aae1;"></i> Manage Comments</h1>
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <!-- Main Start -->
   <section class="container py-2 mb-4">
   <div class="row" style="min-height: 30px;">
      <div class="col-lg-12" style="min-height: 400px;">
         <?php echo ErrorMessage(); ?>
         <?php echo SuccessMessage(); ?>
         <h2>Un-Approved Comments</h2>
         <table class="table table-striped table-hover">
            <thead class="thead-dark">
               <tr>
                  <th>No.</th>
                  <th>Date&Time</th>
                  <th>Name</th>
                  <th>Comment</th>
                  <th>Approve</th>
                  <th>Action</th>
                  <th>Details</th>
               </tr>
            </thead>
         <?php
           // $Con;
           $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
           $Execute = $ConnectingDB->query($sql);
           $SrNo = 0;
           while ($DataRows=$Execute->fetch()) {
              $CommentID = $DataRows['id'];
              $DateTimeOfComment = $DataRows['datetime'];
              $CommenterName = $DataRows['name'];
              $CommenterContent = $DataRows['comment'];
              $CommenterPostID = $DataRows['post_id'];
              $SrNo++;
         ?>
         <tbody>
            <tr>
               <td><?php echo htmlentities($SrNo); ?></td>
               <td><?php echo htmlentities($DateTimeOfComment); ?></td>
               <td><?php echo htmlentities($CommenterName); ?></td>
               <td><?php echo htmlentities($CommenterContent); ?></td>
               <td style="width: 140px;"><a href="approvecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-success">Approve</a></td>
               <td><a href="deletecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-danger">Delete</a></td>
               <td><a class="btn btn-primary" href="fullpost.php?id=<?php echo $CommenterPostID; ?>" target="_blank">Live Preview</a></td>
            </tr>
         </tbody>
         <?php } ?>
         </table>

         <h2>Approved Comments</h2>
         <table class="table table-striped table-hover">
            <thead class="thead-dark">
               <tr>
                  <th>No.</th>
                  <th>Date&Time</th>
                  <th>Name</th>
                  <th>Comment</th>
                  <th>Revert</th>
                  <th>Action</th>
                  <th>Details</th>
               </tr>
            </thead>
         <?php
           // $Con;
           $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id DESC";
           $Execute = $ConnectingDB->query($sql);
           $SrNo = 0;
           while ($DataRows=$Execute->fetch()) {
              $CommentID = $DataRows['id'];
              $DateTimeOfComment = $DataRows['datetime'];
              $CommenterName = $DataRows['name'];
              $CommenterContent = $DataRows['comment'];
              $CommenterPostID = $DataRows['post_id'];
              $SrNo++;
         ?>
         <tbody>
            <tr>
               <td><?php echo htmlentities($SrNo); ?></td>
               <td><?php echo htmlentities($DateTimeOfComment); ?></td>
               <td><?php echo htmlentities($CommenterName); ?></td>
               <td><?php echo htmlentities($CommenterContent); ?></td>
               <td style="width: 140px;"><a href="disapprovecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-warning">Dis-Approve</a></td>
               <td style="width: 140px;"><a href="deletecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-danger">Delete</a></td>
               <td style="width: 140px;"><a class="btn btn-primary" href="fullpost.php?id=<?php echo $CommenterPostID; ?>" target="_blank">Live Preview</a></td>
            </tr>
         </tbody>
         <?php } ?>
         </table>
      </div>
   </div>
   </section>
   <!-- Main End -->
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
