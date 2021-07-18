<?php
include "config.php";
$url = mysqli_real_escape_string($con,$_POST['url']);//get url to check
//set up session
$curlInit = curl_init($url);
curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
curl_setopt($curlInit,CURLOPT_HEADER,true);
curl_setopt($curlInit,CURLOPT_NOBODY,true);
curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
//get reply
$result = curl_exec($curlInit);
curl_close($curlInit);
//submit answer
if ($result){
    echo json_encode(1);
}else{
    echo json_encode(0);
} 