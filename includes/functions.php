<?php require_once("includes/DB.php"); ?>
<?php 
function Redirect_to($New_location)
{
 header("Location:".$New_location);  
 exit;

}

function CheckUserNameExistsOrNot($Username)
{
   global $ConnectingDB;
   $sql = "SELECT username FROM admins WHERE username=:userNem";  
   $stmt = $ConnectingDB->prepare($sql);
   $stmt->bindValue(':userNem',$Username);
   $stmt->execute();
   $Result = $stmt->rowcount();
   if ($Result==1) {
      return true;
   }else{
      return false;
      }
}
function Login_Attempt($Username,$Password)
{
   global $ConnectingDB;
         $sql = "SELECT * FROM admins WHERE username=:userNem AND password=:pasWurd LIMIT 1";
         $stmt = $ConnectingDB->prepare($sql);
         $stmt->bindValue(':userNem',$Username);
         $stmt->bindValue(':pasWurd',$Password);
         $stmt->execute();
         $Result = $stmt->rowCount();
         if ($Result==1) {
            return $Found_Account=$stmt->fetch();
         }else {
            return null;
         }
}

function Confirm_Login()
{
   if (isset($_SESSION['User_ID'])) {
    return true;
 }  else {
    $_SESSION['ErrorMessage']="Login Required!";
    Redirect_to("login.php");
 }
}
?>
