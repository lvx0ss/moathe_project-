<?php
include_once __DIR__ . '/../config.php';
 
	echo '<script>alert("وداعــــــــــــاً")</script>';
	session_start();
	$_SESSION["id"] = "";
	session_destroy();
	header('location: index.php');
?>