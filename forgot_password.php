<?php 
	session_start();
	
	if (isset($_POST['submit']))
	{
		include_once "refiner.php";
		$_SESSION['email'] = $_POST['email'];
		$headers = 'MIME-Version: 1.0\r\nContent-type: text/html;charset=UTF-8'.'From: <llanga@student.wethinkcode.co.za>';
		$subject = "password reset";
		$msg = "click here to reset your password http://localhost:8080/camagru/reset_user.php";
		mail($_SESSION['email'], $subject, $msg, $headers);
	}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<?php include "header.php"?>
</head>
<body>
	<form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="field">
		<label for="email">email</label>
		<input type="email" name="email" class="input"> 
		<br>
		<button name="submit" class="button" type="submit">reset</button>
	</div>
	</form>
</body>
</html>