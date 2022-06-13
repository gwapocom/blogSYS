<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
   if (isset($_GET['id'])) {
      $SearchQueryParameter = $_GET['id'];   
      global $ConnectingDB;
      $Admin = $_SESSION['AdmiName'];
      $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
      $Execute = $ConnectingDB->query($sql);
      if ($Execute) {
         $_SESSION['SuccessMessage']="Comment Dis-Approved Successfully!";
         Redirect_to("comment.php");
      }else {
         $_SESSION['ErrorMessage']="Something Went Wrong. Try Again!";
         Redirect_to("comment.php");
      }
   }
?>
