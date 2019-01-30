<?php 
	session_start();
	include_once "config/setup.php";
	include_once "refiner.php";

	if (isset($_POST['username']) && !empty($_POST['username']))
	{
	  if ($_SESSION['login'])
	  {
			$q = $start->conn->prepare("UPDATE x.media SET uploader = ? WHERE uploader = ?");
			$q->execute([$_POST['username'], $_SESSION['login']]);
			$q = $start->conn->prepare("UPDATE x.comments SET commenter = ? WHERE commenter = ?");
			$q->execute([$_POST['username'], $_SESSION['login']]);
			$q = $start->conn->prepare("UPDATE x.likes SET liker = ? WHERE liker = ?");
			$q->execute([$_POST['username'], $_SESSION['login']]);
			$q = $start->conn->prepare("UPDATE x.users SET `username` = ? WHERE `username` = ?");
			$q->execute([$_POST['username'], $_SESSION['login']]);
			$_SESSION['login'] = $_POST['username'];
	  }
	}
	if (isset($_POST['password']) && isset($_SESSION['login']) && !empty($_POST['password']))
	{
	  $hword = hash("whirlpool", $_POST['password']);
	  $q = $start->conn->prepare("UPDATE x.users SET `password` = ? WHERE `username` = ?");
	  $q->execute([$hword, $_SESSION['login']]);
	}
	if (isset($_POST['email']) && isset($_SESSION['login']) && !empty($_POST['email']))
	{
		if (!empty($_POST['email']))
		{
			$q = $start->conn->prepare("UPDATE x.users SET `email` = ? WHERE `username` = ?");
			$q->execute([$_POST['email'], $_SESSION['login']]);
			mail($_POST['email'], "email change","<p>so this is your new email address, cool.</p>","From: 1ucas@camagru");
		}
		
	}
	if (isset($_POST['email_annoy']) && isset($_SESSION['login']) && !empty($_POST['email_annoy']))
	{
		if($_POST['email_annoy'] == "yes")
		{
			$q = $start->conn->prepare("UPDATE x.users SET `notification` = '1' WHERE `username` = ?");
			$q->execute([$_SESSION['login']]);
		}
		else if ($_POST['email_annoy'] == "no")
		{
			$q = $start->conn->prepare("UPDATE x.users SET `notification` = '0' WHERE `username` = ?");
			$q->execute([$_SESSION['login']]);
		}
	}
	header("Location: http://localhost:8080/camagru/home.php");
	?>