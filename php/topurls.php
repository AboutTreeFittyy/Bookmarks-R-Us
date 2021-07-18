<?php
include "config.php";
//select up to the top ten most commonly found links in the database and sort them by descending order with this query
//$sql_query = "SELECT url FROM urls WHERE userid='".$uid[0]."'";
$sql = "SELECT `url`, COUNT(`url`) AS `value_occurrence` FROM `urls` GROUP BY `url` ORDER BY `value_occurrence` DESC LIMIT 10";
$result = mysqli_query($con,$sql);
if($result){
    echo "<table>";
    if(mysqli_num_rows($result) > 0){
        //Fetch rows
        $cnt = 0;
        while($row = mysqli_fetch_array($result)){
            $cnt++;
            echo "<tr><td>".$cnt."<a href='".$row['url']."'>".$row['url']."</a></td></tr>";
        }
    }else{
        echo "<tr><td>No URLS have been added by you yet.</td></tr>";
    }
    echo "</table>";
}else{
    echo 0;//failed
}