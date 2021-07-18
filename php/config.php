<?php
/*FileName: config.php
 *Modified: October 28, 2019
 *About: This is the generic php configuration file. Used by other php files to access the database.
*/
session_start();
$host = "localhost"; /* Host name */
$user = "mathocga_testee"; /* User */
$password = "G94X84eVbRjidB7"; /* Password */
$dbname = "mathocga_a2p1"; /* Database name */

$con = mysqli_connect($host,$user,$password,$dbname);
//Check connection
if (!$con) {
  die("Unable to connect to DB: " . mysqli_connect_error());
}