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
	<style>
		/* #thumbs>img{
			float : left;
			display:inline;
		} */
	</style>
<?php include "seshheader.php"?>
  <div class="container">
	  <div id="stickers" style="clear:both">
		<img src="assets/stickers/reaper.png" width="100px" height="130px"  id="reaper">
		<img src="assets/stickers/moira.png" width="100px" height="130px"  id="moira">
		<img src="assets/stickers/dva.png" width="100px" height="130px"  id="dva">
		<img src="assets/stickers/trasad.png" width="100px" height="130px"  id="tracer">
		<img src="assets/stickers/flying_insects.png" width="100px" height="130px"  id="insects">
		<img src="assets/stickers/Brigitte_Cute.png" width="100px" height="130px"  id="mace">
		<img src="assets/stickers/dvaritos.png" width="100px" height="130px"  id="doritos">
		<img src="assets/stickers/rat.png"  width="100px" height="130px" id="jrat">
		<img src="assets/stickers/lucio.png" width="100px" height="130px" id="lucio">
		<img src="assets/stickers/boop.png" width="100px" height="130px" id="sombra">
		<img src="assets/stickers/ashe.png" width="100px" height="130px" id="ashe">
		<img src="assets/stickers/thehog.png" width="100px" height="130px" id="hog">
	  </div>
	<video id="video"></video>
	<canvas id="canvas" width="auto" height="auto"></canvas><br>
	<button  onclick="snap();">Snap</button>
	<button id="x" type="button" onclick="pushIt();">push cam image</button>
  </div>
  <!-- <img src="" id="supImage" width="200px" height="200px" /> -->
	<form action="uploader.php" method="post" enctype="multipart/form-data">
	Select image to upload:
		<input type="file" name="regular_images[]" name="fileToUpload" id="fileToUpload" multiple>
		<input type="submit"  alue="Upload Image" name="submit">
	</form>
	<?php include_once "config/setup.php";
	$sql = "SELECT `filename` FROM x.media WHERE `uploader` = :this_user";
	$get_user_images = $start->conn->prepare($sql);
	$get_user_images->bindValue(':this_user', $_SESSION['login']);
	$get_user_images->execute();
	$images = $get_user_images->fetchAll(PDO::FETCH_ASSOC);
	$limit = $get_user_images->rowCount();
	echo "<div class='container' id='thumbs'>";
	for ($i = 0; $i < $limit; $i++)
	{
		echo "<div style='float:left'>";
		echo "<img  class='image is-128x128' style='display:inline' src=uploads/".$images[$i]['filename'].">";
		echo 	"<form action='rm_images.php' method='post'>
					<button type='submit' name='trashit' value=".$images[$i]['filename']." >Delete</button>
				</form>";
		echo "</div>";
	}
	echo "</div>";
?>
	<script src="cam.js" type="text/javascript"></script>
</body>
</html>