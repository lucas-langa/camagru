<?php
 	function sanitize()
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET")
		{
			$target = $_SERVER['REQUEST_METHOD'];
			$arr = $GLOBALS["_".$target];
			foreach($GLOBALS["_".$target] as $key => $value)
			{
				$GLOBALS["_".$target][$key] = htmlspecialchars($value);
				$GLOBALS["_".$target][$key] = stripslashes($value);
				$GLOBALS["_".$target][$key] = strip_tags($value);
			}
		}
	}
	sanitize();