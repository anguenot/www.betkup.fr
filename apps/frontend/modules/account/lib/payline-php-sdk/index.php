<?php

	$pathDemos = "examples/demos/index.php";
	if (file_exists($pathDemos)) {
		header("Location: examples/demos/index.php");
		exit;
	}

?>