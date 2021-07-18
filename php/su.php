<?php
include "config.php";

$uname = mysqli_real_escape_string($con,$_POST['username']);
$password = mysqli_real_escape_string($con,$_POST['password']);

if ($uname != "" && $password != ""){
    $sql_query = "SELECT COUNT(*) AS cntUser FROM users WHERE USERNAME='".$uname."' AND PASSWORD='".$password."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_array($result);
    $cnt = $row['cntUser'];

    if($cnt > 0){
        //username already exists, exit
		$_SESSION['uname'] = $uname;
        echo 0;
    }else{
        //add new user
		$sql_query = "INSERT INTO `users` (`id`, `username`, `name`, `password`) VALUES (NULL, '".$uname."', '".$uname."', '".$password."')";
		if(mysqli_query($con,$sql_query)){
			echo 1;//success
		}else{
			echo 0;//failed
		}
    }
}