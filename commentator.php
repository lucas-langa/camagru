<?php
	require_once "config/setup.php";
	session_start();
	function get_username($user)
	{
		require "config/database.php";
		$start = new connection($DB_DSN, $DB_USER, $DB_PASSWORD);
		$res = $start->conn->prepare("SELECT username FROM x.users WHERE id =:human");
		$res->bindValue(':human', $user);
		$res->execute();
		$start->__destruct();
		$digit = $res->fetch();
		return ($digit['username']);
	}
	
	if (isset($_SESSION['login']) && isset($_POST['comment']) && isset($_POST['image']) && isset($_POST['commentate']))
	{
		include_once "refiner.php";
		/*
		why do i need to resolve user id again?,insert the id of the commenter
		id foreign key
		filename
		comment
		commenter
		*/
		$curr_uid = resolve_user($_SESSION['login']); 
		$sql = "INSERT INTO x.comments SET `filename` = ?, `comment` = ?, `commenter` = ?, `id` = ?,`comment_id` = UUID(),`date` = SYSDATE()";
		$insert_comment = $start->conn->prepare($sql);
		$insert_comment->execute([$_POST['image'], $_POST['comment'], $_SESSION['login'], $curr_uid]);
		$sql = "SELECT user_id FROM x.likes WHERE `filename` = :files";
		$get_imageowner = $start->conn->prepare($sql);
		$get_imageowner->bindValue(':files', $_POST['image']);
		$get_imageowner->execute();
		$imageowner = $get_imageowner->fetch(PDO::FETCH_ASSOC);
		// var_dump(	$imageowner);
		// die();
		$n = $start->conn->prepare("SELECT email FROM x.users WHERE notification = '1' AND `id` = ?");
		$n->execute([$imageowner['user_id']]);
		$email = $n->fetch();
		// var_dump($email);
		// die();
		if (!empty($email))
		{
			$liker = $_SESSION['login'];
			if (isset($_POST['like']))
			{
				$sub = "like";
				$msg = "$liker just like your picture";
			}
			if (isset($_POST['commentate']))
			{
				$sub = "comment";
				$msg = "$liker just commented on your picture";
			}
			mail($email['email'],$sub,$msg,'MIME-Version: 1.0\r\nContent-type: text/html;charset=UTF-8'.'From: <llanga@student.wethinkcode.co.za>');
		}
		// echo "comment inserted";
	}
	header('location: http://localhost:8080/camagru/gallery.php');
	// $sql = "INSERT ";
?>