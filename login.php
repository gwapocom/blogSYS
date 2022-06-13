<?php require_once "includes/DB.php"; ?>
<?php require_once "includes/functions.php"; ?>
<?php require_once "includes/sessions.php"; ?>
<?php 
   if (isset($_SESSION['User_ID'])) {
      Redirect_to('dashboard.php');
   }

   if (isset($_POST['submit'])) {
      $Username = $_POST['username'];
      $Password = $_POST['password'];
      if (empty($Username)||empty($Password)) {
         $_SESSION['ErrorMessage']="All fields must be filled out";
         Redirect_to("login.php");
      }else {
         //code for checking username and password from Databse
         $Found_Account=Login_Attempt($Username,$Password);
         if ($Found_Account) {
            $_SESSION['User_ID']=$Found_Account['id'];
            $_SESSION['Username']=$Found_Account['username'];
            $_SESSION['AdmiName']=$Found_Account['aname'];
            $_SESSION['SuccessMessage']="Welcome Admin ".$_SESSION['AdmiName']."!";
            if(isset($_SESSION['TrackingURL'])){
               Redirect_to($_SESSION['TrackingURL']);
            }else{
               Redirect_to("dashboard.php");
            }

         }else {
            $_SESSION['ErrorMessage']="Incorrect Username/Password";
            Redirect_to("login.php");
         }
      }
   }
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <title>Login</title>
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
            </div>
         </div>
      </div>
   </header>
   <!-- HEADER END -->
   <!-- Main Start -->
   <section class="container py-2 mb-4">
      <div class="row">
         <div class="offset-sm-3 col-sm-6" style="min-height: 500px;">
            <br><br> <br>
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
            ?>
            <div class="card bg-secondary text-light">
               <div class="card-header">
                  <h4>Welcome Back!</h4>
               </div>
                  <div class="card-body bg-dark">
                     <form class="" action="login.php" method="POST">
                        <div class="form-group">
                           <label for="username"><span class="FieldInfo">Username:</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text text-white bg-info">
                                    <i class="fa-solid fa-user"></i>
                              </span>
                              </div>
                              <input class="form-control" name="username" id="username" value="">
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="password"><span class="FieldInfo">Password:</span></label>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text text-white bg-info">
                                    <i class="fa-solid fa-lock"></i>
                              </span>
                              </div>
                              <input class="form-control" name="password" id="password" type="password" value="">
                           </div>
                        </div>
                        <input type="submit" name="submit" class="btn btn-info btn-block" value="login">
                     </form>
               </div>
            </div>
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
