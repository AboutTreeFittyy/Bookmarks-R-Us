 <?php
include "config.php";

$url = mysqli_real_escape_string($con,$_POST['nurl']);
$uname = mysqli_real_escape_string($con,$_POST['name']);

if ($uname != "" && $url != ""){
	$userid_query = "SELECT `id` FROM `users` WHERE `username` = '".$uname."'";
	$userid = mysqli_query($con,$userid_query);
	
	if($userid){
		//add new url
		$uid = mysqli_fetch_array($userid);
		$sql_query = "INSERT INTO `urls` (`id`, `userid`, `url`) VALUES (NULL, '".$uid[0]."', '".$url."')";
		if(mysqli_query($con,$sql_query)){
			echo 1;//success
		}else{
			echo 0;//failed
		}
	}else{
		echo 0;//failed
	}
}