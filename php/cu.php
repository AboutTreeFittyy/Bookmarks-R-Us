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
        $_SESSION['uname'] = $uname;
        echo 1;
    }else{
        echo 0;
    }
}