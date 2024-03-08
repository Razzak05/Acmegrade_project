<?php

if(!isset($_POST['uname']) || !isset($_POST['upass1']))
{
    echo "Missing Parameters"; 
    die;
}
$conn = new mysqli("localhost","root","","acme_database",3306); 

$status=mysqli_query($conn,"insert into user(username,password,usertype) values('$_POST[uname]','$_POST[upass1]','$_POST[usertype]')");

if($status){
    echo "Registration Successful!"; 
}
else{
    echo mysqli_error($conn);
}
?>
