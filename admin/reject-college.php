<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}


require_once("../db.php");

if(isset($_GET)) {

	//Delete Company using id and redirect
	$sql = "UPDATE college SET active='0' WHERE id_college='$_GET[id]'";
	if($conn->query($sql)) {
		header("Location: colleges.php");
		exit();
	} else {
		echo "Error";
	}
}