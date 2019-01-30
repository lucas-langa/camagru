<?php
	session_start();
	include_once "refiner.php";
	$imgfile = file_get_contents("php://input");
	$x = explode(',', $imgfile);
	$photo = base64_decode($x[1]);
	$img_name = uniqid().".png";
	if (!file_exists("uploads/"))
	{
		mkdir("uploads/");
	}
	file_put_contents("uploads/".$img_name, $photo);

	include "config/setup.php";
	$query = $start->conn->prepare("INSERT INTO x.media SET `uploader`=:uname, `filename` = :fname, `date` = SYSDATE()");
	$query->bindParam(':uname', $_SESSION['login']);
	$query->bindParam(':fname', $img_name);
	$query->execute();
?>