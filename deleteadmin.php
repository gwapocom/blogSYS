<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
   if (isset($_GET['id'])) {
      $SearchQueryParameter = $_GET['id'];   
      global $ConnectingDB;
      $sql = "Delete FROM admins WHERE id='$SearchQueryParameter'";
      $Execute = $ConnectingDB->query($sql);
      if ($Execute) {
         $_SESSION['SuccessMessage']="Admin Deleted Successfully!";
         Redirect_to("admin.php");
      }else {
         $_SESSION['ErrorMessage']="Something Went Wrong. Try Again!";
         Redirect_to("admin.php");
      }
   }
?>
