 <?php
include "config.php";
$uname = mysqli_real_escape_string($con,$_POST['name']);
$url = mysqli_real_escape_string($con,$_POST['newrl']);
if ($uname != ""){	
	$userid_query = "SELECT `id` FROM `users` WHERE `username` = '".$uname."'";
	$userid = mysqli_query($con,$userid_query);
	if($userid){		
		//add new url
		$uid = mysqli_fetch_array($userid);
		//$sql_query = "SELECT id FROM urls WHERE url = '".$url."' AND userid = '".$uid[0]."'";
		$sql = "SELECT id FROM urls WHERE url = '".$url."' AND userid = '".$uid[0]."'";
		$result = mysqli_query($con,$sql);
		if (mysqli_num_rows($result)) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}else{
		echo json_encode(0);//failed
	}
}