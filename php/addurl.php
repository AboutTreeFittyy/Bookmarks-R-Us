 <?php
include "config.php";

$url = mysqli_real_escape_string($con,$_POST['newrl']);
$uname = mysqli_real_escape_string($con,$_POST['name']);

if ($uname != "" && $url != ""){
	$userid_query = "SELECT `id` FROM `users` WHERE `username` = '".$uname."'";
	$userid = mysqli_query($con,$userid_query);
	
	if($userid){
		//add new url
		$uid = mysqli_fetch_array($userid);
		$sql_query = "INSERT INTO `urls` (`id`, `userid`, `url`) VALUES (NULL, '".$uid[0]."', '".$url."')";
		if(mysqli_query($con,$sql_query)){
			echo json_encode(1);
		}else{
			echo json_encode(0);
		}
	}else{
		echo json_encode(0);//failed
	}
}