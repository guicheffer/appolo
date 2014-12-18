<?php
	$_SESSION = array();
	session_destroy();
	session_start();
	$_SESSION['warn']="10";
	header("location:".APPOLO_LOGIN);
?>