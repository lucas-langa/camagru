<?php 
	include "./header.php";
	include "./config/database.php";
	include "./db.class.php";
	
	if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']))
	{
			include_once "refiner.php";
			session_start();
			$_SESSION['login'] = $_POST['username'];
			$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
			$x = $net->conn->prepare("SELECT * FROM `users` WHERE `username` = ? AND `confirm` = 1");
			$x->execute([$_POST['username']]);
			$q = $x->fetch();
			$pwd = hash('whirlpool', $_POST['password']);
			if ($pwd == $q['password'])
			{
				header("Location: http://localhost:8080/camagru/home.php");
				die();
			}
			if ((!password_verify($_POST['password'] , $q['password'])))
			{
				session_destroy();
				header("Location: http://localhost:8080/camagru/login.php");
				echo "no";
				die();
			}
			if (!$q && password_verify($_POST['password'] , $q['password']))
			{
				session_destroy();
				header("Location: http://localhost:8080/camagru/login.php");
				echo "account hasn't been activated";
				die();
			}
			if (!$q)
			{
				session_destroy();
				header("Location: http://localhost:8080/camagru/login.php");
				echo "invalid combo";
				die();
			}
			if ($q['confirm'] === 0)
			{
				session_destroy();
				header("Location: http://localhost:8080/camagru/login.php");
				echo "account hasn't been activated";
				die();
			}
			else if (!$q)
			{
				session_destroy();
				header("Location: http://localhost:8080/camagru/login.php");
				echo "account no exist combo";
				die();
			}
	}
?>
	

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
<form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	<div class="field">
		<label class="label" for="username">Username</label>
		<input id="uname" pattern="\w+" class="input" type="text" name="username" placeholder="enter your username" required="required">
		<br>
		<label for="password" class="label">Password</label>
		<input id="pwd" class="input" title="uppercase and lowercase letters with at least one digit"  type="password" name="password" placeholder="enter your password" required="required" minlength="8" autocomplete="off">
		<br>
		<br>
		<div class="meh">
		<button type="reset" class="button" >clear</button>
		<button class="button" type="submit" name="submit" >login</button>
		<br/>
		<a href="forgot_password.php">Forgot your password?</a>
		<br/>
		<p>No account, sign up now</p>
		<a href="./index.php"><button class="button" type="button">Sign up</button></a>
		</div>
		</div>
</form>
		<script src="xjs.js" type="text/javascript">
		</script>
</body>
</html>