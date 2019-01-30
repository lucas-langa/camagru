<?php
	session_start();
	if (empty($_SESSION['key']))
		$_SESSION['key'] = bin2hex(random_bytes(33));
	
		$csrf = hash_hmac('sha256', "i don't know mane: index.php", $_SESSION['key']);

		if (isset($_POST['submit'])) {
			if (!(hash_equals($csrf, $_POST['csrf']))) {
				die();
			}
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign up</title>
		<?php include "./header.php"?>
		<form action="sign_up.php" method="post">
			<div class="field">
				<label for="name" class="label">name</label>
				<input class="input" type="text" name="name" placeholder="first name please" required="required">
				<br>	
				<label class="label" for="surname">surname</label> 
				<input class="input" type="text" name="surname" placeholder="last name please" required="required">
				<br>
				<label class="label" for="username">Username</label>
				<input onchange="handle_response();" formmethod="get" id="uname" pattern="\w+" class="input" type="text" name="username" placeholder="words only" required="required">
				<br>
				<label for="email" class="label">Email</label>
				<input class="input" type="email" name="email" placeholder="email@example.com" required="true">
				<br>
				<label for="password" class="label">Password</label>
				<input class="input" id="password" title="uppercase and lowercase letters with at least one digit"  type="password" name="password" placeholder="must be 8 characters long, contain lower and upper-case characters" required="required" minlength="8" autocomplete="off" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*">
				<br>
				<label for="passwd_verify" class="label">Confirm Password</label>
				<input id="passwd_verify"class="input" onblur="assertPassword()" type="password" name="passwd_verify" placeholder="re-type your password to confirm" required="required" minlength="8" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*" autocomplete="off">
				<br>
				<br>
				<input type="hidden" name="csrf" value="<echo $csrf ?>">
				<div class="meh">
				<button type="reset" class="button" >Cancel</button>
				<button class="button" name="submit" type="submit">Submit</button>
				<br/>
				<p>
				<a href="login.php"><button class="button" type="button" >login</button></a>
				</div>
				</div>
		</form>
		<script src="xjs.js" type="text/javascript">
		</script>
	</body>
</html>
<!-- pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*" -->
<!--  pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*" --> 