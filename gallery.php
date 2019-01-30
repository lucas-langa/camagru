<?php
	session_start();
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php if (isset($_SESSION['login']))
			include "seshheader.php";
		else
			include "header.php";
	?>
</head>
<body>
    <div class="container">
		<?php
			include_once "config/setup.php";
			
			include_once "refiner.php";
            $results_per_page = 5;
            $sq = "SELECT * FROM x.media";
            $result = $start->conn->prepare($sq);
            $result->execute();
            $rows = $result->fetchAll();
            $number_of_results = $result->rowCount();
            $number_of_pages = ceil($number_of_results/$results_per_page);
			if (!isset($_GET['page'])) {
				$page = 1;
            } else {
				$page = $_GET['page'];
			}			
            $this_page_first_results =  ($page - 1)* $results_per_page;
			$sq = "SELECT `filename` FROM x.media ORDER BY `date` DESC LIMIT :offset,:other";
			//. $this_page_first_results . ',' .$results_per_page;
            $result = $start->conn->prepare($sq);
            $result->bindValue(':offset',(int)$this_page_first_results, PDO::PARAM_INT);
            $result->bindValue(':other', (int)$results_per_page, PDO::PARAM_INT);
            $result->execute();
			$rows = $result->fetchAll();
			
			$sq = "SELECT * FROM x.likes WHERE `filename` = :file";
			$get_commentsql = "SELECT `comment`, `commenter` FROM x.comments WHERE `filename` = :file ORDER BY `date` DESC";
			foreach($rows as $i)
			{
                foreach($i as $k)
				{
                    $res = "./uploads/".$k;
					echo "<img align='center' src='".$res."' width='640' height='480'><br><br>";
					$like_result = $start->conn->prepare($sq);
					$like_result->bindValue(':file',$k);
					$like_result->execute();
					$likes = $like_result->rowCount();
					if (isset($_SESSION['login']))
						echo "<form><br><button class='button is-primary is-small' type='submit' name='like' formmethod='post' formaction='get_likes.php' value='$k'>like</button><br></form>";
					/*
					**fix up comment retrieval and display, a foreach loop of sorts
					**done
					*/
					$gimme_comments = $start->conn->prepare($get_commentsql);
					$gimme_comments->bindValue(':file', $k);
					$gimme_comments->execute();
					$comment_data = $gimme_comments->fetchAll(PDO::FETCH_ASSOC);
					echo "$likes <span>likes</span>";
                    echo "<br>";
                    echo "<br>";
					if (!empty($comment_data))
					{
						foreach($comment_data as $cd)
							echo "<span>".$cd['commenter'].": ".$cd['comment']."</span><br>";
						
					}
					if (isset($_SESSION['login']))
					{
						echo      "<article class=\"media\">";
						echo "<form action='commentator.php' method='post'>";
						echo    "<div class=\"media-content\">";
						echo        "<div class=\"field\">";
						echo        "<p class=\"control\">";
						echo            "<textarea class=\"textarea\" name='comment' placeholder=\"Add a comment...\"></textarea>";
						echo		"<input type='hidden' name='image' value=$k>";
						echo 		"<input class='button is-primary' type='submit' name='commentate' placeholder='type some stuff'/>";
						echo        "</p>";
						echo        "</div>";
						echo 	"</form>";
						echo        "</div>";
						echo        "</nav>";
						echo    "</div>";
						echo    "</article>";
					}
				}
            }
            for ($page = 1;$page <= $number_of_pages; $page++) {
                echo '<a href="gallery.php?page=' . $page . '">' . " page ".$page .'</a> ';
            }
        ?>
    </div>
</body>
</html>