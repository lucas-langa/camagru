<?php
require "config/setup.php";
session_start();
	if (isset($_SESSION['login']))
	{
		if (isset($_POST['submit'])) {
			include_once "refiner.php";
			$images = $_FILES['regular_images'];
			$i = count($images['name']);
			for ($x = 0;$x < $i; $x++)
			{
				$fileName = $images['name'][$x];
				$fileTmpName = $images['tmp_name'][$x];
				$fileSize = $images['size'][$x];
				$fileError = $images['error'][$x];
				$fileType = $images['type'][$x];
				$fileExt = explode('.', $fileName);
				$fileActualExt = strtolower(end($fileExt));
				$allowed = array('jpg', 'jpeg', 'png');
		
				if (in_array($fileActualExt, $allowed)) {
					if ($fileError === 0) {
						if ($fileSize < 1000000) {
							try {
								$fileNameNew = uniqid('', true).".$fileActualExt";
								$fileDestination = 'uploads/'.$fileNameNew;
								move_uploaded_file($fileTmpName, $fileDestination);
								$query = $start->conn->prepare("INSERT INTO x.media SET `uploader`=:uname, `filename` = :fname, `date` = SYSDATE()");
								$query->bindParam(':uname', $_SESSION['login']);
								$query->bindParam(':fname', $fileNameNew);
								echo $fileNameNew;
								$query->execute();
							}
							catch(Exception $e) {
								echo $e->getMessage();
							}
						} else {
							$fileError = 1;
							echo "This file is massive!";
						}
					} else {
						$fileError = 1;
						echo "There was an error uploading your file";
					}
				} else {
					$fileError = 1;
					echo "You cannot upload such file types";
				}
			}
			if (!$fileError)
				echo "files uploaded";
		}
	}
?>