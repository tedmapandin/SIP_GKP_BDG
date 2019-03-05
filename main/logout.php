<?php 
	session_start();
	session_destroy();
	header("location:http://localhost/SIP_GKP_BDG/main/login.php");
?>