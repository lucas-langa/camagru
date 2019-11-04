<?php
	session_start();
    if (isset($_SESSION['email']))
    {
		require_once "config/setup.php";
        $setStr = "";
        $setStr .= "`" . str_replace("`", "`", "email"). "` = :email";
        $y = trim($_SESSION['email']);
        $q = $start->conn->prepare("SELECT `email` FROM x.users WHERE $setStr");
        $q->bindParam(':email',$y);
        $q->execute();
        $result = $q->fetch();
        if (!$result)
        {
			echo "NOPE";
            header("Location: http://localhost:8080/camagru/index.php");
        }
        else
        {
			//echo "<script>alert('selected');</script>";
            if (isset($_POST['pwd_verify']) && isset($_POST['submit']))
            {
		include_once "refiner.php";
		//has function that cleans up form data 		
                $mail = $result['email'];
                $x = hash("whirlpool", $_POST['pwd_verify']);
                $q = $start->conn->prepare("UPDATE x.users SET `password`=? WHERE email = '$mail'");
                //echo $x;
                //not important
// 	    	echo "<script>alert($x);</script>";
                $q->execute([$x]);
               // header("Location: http://localhost:8080/camagru/login.php");
            }            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include "header.php"?>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
    <div class="field">
        <label for="passwd">Password</label>
        <input type="password" name="passwd">
        <label for="pwd_verify">confirm your password</label>
        <input type="password" name="pwd_verify" min="8">
        <button class="button" type="submit" name="submit">reset</button>
    </div>
</body>
</html>
