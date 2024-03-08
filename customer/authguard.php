<?php
  session_start(); // Make sure to start the session before accessing session variables
  
  if(!isset($_SESSION['login_status'])){
    echo "Illegal Attempt, Login Bypassed";
    die;
 }
 
 if($_SESSION['login_status']==false){
    echo "unauthorized Access,403:Forbidden";
    die;
 }

 if($_SESSION['usertype'] != 'Customer'){
    echo "Permission Denied, Authorization Failed";
    die;
 }

 echo '<div class="d-flex justify-content-evenly">
  
 <div>';
      echo $_SESSION['userid'];
 echo '</div>
 <div>';
      echo $_SESSION['username'];
 echo '</div>
 <div>
   <a href="../shared/logout.php">Logout</a>
 </div>
 </div>';
?>
