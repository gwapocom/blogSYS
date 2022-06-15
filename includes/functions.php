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

function TotalPosts()
{
   global $ConnectingDB;  
   $sql = "SELECT COUNT(*) FROM posts";
   $stmt = $ConnectingDB->query($sql);
   $TotalRows = $stmt->fetch();
   $TotalPosts = array_shift($TotalRows);
   echo $TotalPosts;
}

function TotalCategory()
{
   global $ConnectingDB;  
   $sql = "SELECT COUNT(*) FROM category";
   $stmt = $ConnectingDB->query($sql);
   $TotalRows = $stmt->fetch();
   $TotalCategory = array_shift($TotalRows);
   echo $TotalCategory;
}

function TotalAdmin()
{
   global $ConnectingDB;  
   $sql = "SELECT COUNT(*) FROM admins";
   $stmt = $ConnectingDB->query($sql);
   $TotalRows = $stmt->fetch();
   $TotalAdmin = array_shift($TotalRows);
   echo $TotalAdmin;
}


function TotalComment()
{
   global $ConnectingDB;  
   $sql = "SELECT COUNT(*) FROM comments";
   $stmt = $ConnectingDB->query($sql);
   $TotalRows = $stmt->fetch();
   $TotalComment = array_shift($TotalRows);
   echo $TotalComment;
}


function AppCommAccPos($PostID)
{
   
   global $ConnectingDB;
   $sqlApprove= "SELECT COUNT(*) FROM comments WHERE post_id='$PostID' AND status='ON'";
   $stmtApprove=$ConnectingDB->query($sqlApprove);
   $RowsTotal = $stmtApprove->fetch();
   $Total=array_shift($RowsTotal);
   return $Total;
}

function DisAppCommAccPos($PostID)
{
   global $ConnectingDB;
   $sqlDisApprove= "SELECT COUNT(*) FROM comments WHERE post_id='$PostID' AND status='OFF'";
   $stmtDisApprove=$ConnectingDB->query($sqlDisApprove);
   $RowsTotal = $stmtDisApprove->fetch();
   $Total=array_shift($RowsTotal);
   return $Total;
}
?>
