 <?php
include "config.php";
$uname = mysqli_real_escape_string($con,$_POST['name']);

if ($uname != ""){
	$userid_query = "SELECT `id` FROM `users` WHERE `username` = '".$uname."'";
	$userid = mysqli_query($con,$userid_query);
	if($userid){
		//add new url
		$uid = mysqli_fetch_array($userid);
		$sql_query = "SELECT url FROM urls WHERE userid='".$uid[0]."'";
		$result = mysqli_query($con,$sql_query);
		if($result){
			//echo var_dump($userid) . "<br>";
			echo "<table>";
			if(mysqli_num_rows($result) > 0){
				//Fetch rows
				while($row = mysqli_fetch_array($result)){
					echo "<tr><td><div id='".$row['url']."'><a href='".$row['url']."'>".$row['url']."</a><button onClick='edit_click(this.id)' id='".$row['url']."'>Edit</button><button onClick='delete_click(this.id)' id='".$row['url']."'>Delete</button></div></td></tr>";
				}
			}else{
				echo "<tr><td>No URLS have been added by you yet.</td></tr>";
			}
			echo "</table>";
		}else{
			echo 0;//failed
		}
	}else{
		echo 0;//failed
	}
}