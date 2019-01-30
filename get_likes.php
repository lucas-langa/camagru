<?php
	require_once "config/setup.php";
	session_start();
	
	
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['like']) && isset($_SESSION['login']))
	{
		include_once "refiner.php";
		$uid = resolve_user($_SESSION['login']);
		$sq = "SELECT * FROM x.likes WHERE `filename` = :file AND liker =:liker";
		$like_result = $start->conn->prepare($sq);
		$like_result->bindValue(':file', $_POST['like']);
		$like_result->bindValue(':liker', $_SESSION['login']);
		$like_result->execute();
		$likes = $like_result->rowCount();
		if ($likes == 1)
		{
			$sql  = "DELETE FROM x.likes WHERE `filename` = :files AND liker = :liker";
			$remove_like = $start->conn->prepare($sql);
			$remove_like->bindValue(':files', $_POST['like']);
			$remove_like->bindValue(':liker', $_SESSION['login']);
			$remove_like->execute();
			/* $sql = "SELECT user_id FROM x.likes WHERE `filename` = :files";
			$get_imageowner = $start->conn->prepare($sql);
			$get_imageowner->bindValue(':files', $_POST['like']);
			$get_imageowner->execute();
			$imageowner = $get_imageowner->fetch();
			$n = $start->conn->prepare("SELECT email FROM x.users WHERE notification = 1 ANDuser_id =" . $imageowner['username']);
			$n->execute();
			$email = $n->fetch();
			$liker = $_SESSION['login'];
			mail($email,"like","$liker just liked your picture",'MIME-Version: 1.0\r\nContent-type: text/html;charset=UTF-8'.'From: <llanga@student.wethinkcode.co.za>'); */
		}
		else
		{
			$sql = "INSERT INTO x.likes SET `user_id` = ?, img_id = UUID() , `filename` = ?,liker = ?";
			$add_like = $start->conn->prepare($sql);
			$add_like->execute([$uid, $_POST['like'], $_SESSION['login']]);
		}
	}
	header("location: http://localhost:8080/camagru/gallery.php");