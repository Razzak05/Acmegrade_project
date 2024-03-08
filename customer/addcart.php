<?php
include "authguard.php";
include "../shared/connection.php";

$pid=$_GET['pid'];
$sql_status=mysqli_query($conn,"insert into cart(userid,pid) values($_SESSION[userid],$pid)");

if($sql_status){
     header("loaction:home.php");
}else{
    echo mysqli_error($conn);
}
?>