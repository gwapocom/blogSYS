<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $_SESSION['TrackingURL']= $_SERVER["PHP_SELF"]; ?>
 <?php Confirm_Login(); ?>
<?php 
if(isset($_POST['Submit'])){
   $Username = $_POST['username'];
   $Name = $_POST['name'];
$Password = $_POST['password'];
$ConfirmPassword = $_POST['confirmpassword'];
$Admin = $_SESSION['Username'];

date_default_timezone_set("Asia/Karachi");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

if(empty($Username) || empty($Password) || empty($ConfirmPassword)) {
   $_SESSION['ErrorMessage'] = "All fields must be filled out";
    Redirect_to("admin.php");   
 }elseif (strlen($Password)<3) {
    $_SESSION['ErrorMessage'] = "Password title should be greater than 3 characters";
    Redirect_to("admin.php");   
 }elseif ($Password !== $ConfirmPassword) {
    $_SESSION['ErrorMessage'] = "Password and Confirm Password should match";
    Redirect_to("admin.php");   
 }elseif (CheckUserNameExistsOrNot($Username)) {
    $_SESSION['ErrorMessage'] = "Username Exists. Try another One!";
    Redirect_to("admin.php");   
    }else{
      //Query to insert new admin in DB when fine 
      $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
      $sql .="VALUES(:datetime,:userNem,:pasWurd,:aNem,:admiNem)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':datetime',$DateTime);
      $stmt->bindValue(':userNem',$Username);
      $stmt->bindValue(':pasWurd',$Password);
      $stmt->bindValue(':aNem',$Name);
      $stmt->bindValue(':admiNem',$Admin);

      $Execute=$stmt->execute();
      if ($Execute) {
         $_SESSION['SuccessMessage']="New Admin with the name of {$Name} Added Successfully";
         Redirect_to("admin.php");
      } else {
         $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("admin.php");
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
    <title>admin</title>
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
                    <h1><i class="fa-solid fa-user" style="color:27aae1;"></i> Manage Admin</h1>
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
                ?>
                <form class="" action="admin.php" method="post">
                   <div class="card bg-secondary text-light mb-3">
                      <div class="card-header">
                         <h1>Add New Admin</h1>
                      </div>
                      <div class="card-body bg-dark">
                         <div class="form-group">
                            <label for="username"> <span class="FieldInfo">  Username: </span></label>
                            <input class="form-control" type="text" name="username" id="username" placeholder="Type title here" value="">
                         </div>

                         <div class="form-group">
                            <label for="name"> <span class="FieldInfo">  Name: </span></label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Type title here" value="">
                            <small class="text-warning text-muted">Optional</small>
                         </div>

                         <div class="form-group">
                            <label for="password"> <span class="FieldInfo">  Password: </span></label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Type title here" value="">
                         </div>

                         <div class="form-group">
                            <label for="confirmpassword"> <span class="FieldInfo">  Confirm Password: </span></label>
                            <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="">
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
                </form>

                <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                   <thead class="thead-dark">
                      <tr>
                         <th>No.</th>
                         <th>Date&Time</th>
                         <th>Username</th>
                         <th>Admin Name</th>
                         <th>Added by</th>
                         <th>Action</th>
                      </tr>
                   </thead>
                   <?php
                      $sql = "SELECT * FROM admins ORDER BY id DESC";
                      $Execute = $ConnectingDB->query($sql);
                      $SrNo = 0;
                      while ($DataRows=$Execute->fetch()) {
                         $AdminID = $DataRows['id'];
                         $DateTime = $DataRows['datetime'];
                         $AdminUsername = $DataRows['username'];
                         $AdmiName = $DataRows['aname'];
                         $Addedby = $DataRows['addedby'];
                         $SrNo++;
                      ?>
                      <tbody>
                         <tr>
                            <td><?php echo htmlentities($SrNo); ?></td>
                            <td><?php echo htmlentities($DateTime); ?></td>
                            <td><?php echo htmlentities($AdminUsername); ?></td>
                            <td><?php echo htmlentities($AdmiName); ?></td>
                            <td><?php echo htmlentities($Addedby); ?></td>
                            <td style="width: 140px;"><a href="deleteadmin.php?id=<?php echo $AdminID; ?>" class="btn btn-danger">Delete</a></td>
                         </tr>

                      </tbody>
                      <?php } ?>
                   </table>
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
