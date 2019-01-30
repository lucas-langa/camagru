<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
		<?php 
			include_once "refiner.php";
			session_start();
			if (empty($_SESSION['login']))
				include "header.php";
			else
				include "seshheader.php";
		?>
		<?php
			if (isset($_GET['message']))
			{
				echo "<article class='message is-danger'>
  						<div class='message-header'>
    						<p>Danger</p>
			    			<button class='delete' aria-label='delete'></button>
  						</div>
  						<div class='message-body'>"
  							.$_GET['message']."
  						</div>
					</article>";
			}
		?>
</body>
</html>