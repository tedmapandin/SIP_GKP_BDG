<?php
date_default_timezone_set('Asia/Jakarta');

$hostname="localhost";
$username="root";
$password="";
$database="db_sip_gkpbdg";

$conn = mysqli_connect($hostname,$username,$password,$database);

if(!$conn) {
	die("Connection failed : ".mysqli_connect_error());
}
//mysqli_close($conn);
?>