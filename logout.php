<?php require_once "includes/sessions.php"; ?>
<?php require_once "includes/functions.php"; ?>
<?php
   $_SESSION['User_ID']=null;
   $_SESSION['Username']=null;
   $_SESSION['AdmiName']=null;
   session_destroy();
   Redirect_to("login.php");
?>
