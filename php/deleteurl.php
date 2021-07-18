 <?php
include "config.php";
$uname = mysqli_real_escape_string($con,$_POST['name']);
$id = mysqli_real_escape_string($con,$_POST['id']);

if ($uname != ""){
	$userid_query = "SELECT `id` FROM `users` WHERE `username` = '".$uname."'";
	$userid = mysqli_query($con,$userid_query);
	if($userid){
		//add new url
		$uid = mysqli_fetch_array($userid);
		$sql_query = "DELETE FROM urls WHERE userid = '".$uid[0]."' AND url = '".$id."'";
		$result = mysqli_query($con,$sql_query);
		if($result){
			echo 1;//just need to let know if failed or not, already have data to change link on screen
		}else{
			echo 0;//failed
		}
	}else{
		echo 0;//failed
	}
}