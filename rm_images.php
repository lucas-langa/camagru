<?php
	include_once "config/setup.php";
	session_start();
	if (isset($_SESSION['login']) && isset($_POST['trashit']) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		include_once "refiner.php";
		$check_ownership = $start->conn->prepare("SELECT `filename` FROM x.media WHERE `uploader` = :this_peasant");
		$check_ownership->bindValue(':this_peasant', $_SESSION['login']);
		$check_ownership->execute();
		$results = $check_ownership->fetchAll(PDO::FETCH_ASSOC);
		if (!$results)
		{
			$wrath =  "This is not yours, you sack of shit!";
			header("location: http://localhost:8080/camagru/salty_error.php?message=$wrath");
		}
		else
		{
			$rmfromdb = $start->conn->prepare("DELETE FROM x.media WHERE `filename` =:thisimage");
			$rmfromdb->bindValue(':thisimage', $_POST['trashit']);
			$rmfromdb->execute();
			unlink("uploads/".$_POST['trashit']);
			header('location: http://localhost:8080/camagru/home.php');
		}
		echo "<p>".$_POST['trashit']."</p>";
	}
?>