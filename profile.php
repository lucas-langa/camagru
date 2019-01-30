<?php
    session_start();
    if (!isset($_SESSION['login']))
    {
        header("Location: http://localhost:8080/camagru/login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Page Title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include "./seshheader.php"; ?>
</head>
<body>
<div class="notification">
        <strong>This is where you would make changes to Your Account, if i bothered to allow such</strong>
    </div>
    <div class="box">
    <form action="modprofile.php" method="post">
        <label id="username" for="uname" class="label">Username:</label>
        <input name="username" type="text" pattern="\w+">
        <label id="label" for="Password" class="label" id="pwd">Password</label>
        <input type="password" name="password" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*">
        <label id="email" for="email" class="label" id="email">Email: </label>
        <input type="email" name="email">
        <div class="control">
        <label id="label" for="email_annoy"  class="label">Email notifications</label>
        <select name="email_annoy">
            <option value="">Don't change</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        <button class="button" type="submit">try</button>
    </form>
    </div>
    <script src="xjs.js" type="text/javascript">
    </script>
</body>
</html>