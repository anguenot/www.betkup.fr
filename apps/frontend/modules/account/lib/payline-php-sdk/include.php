<?php
	function __autoload($class_name) {
		require_once 'lib/'.$class_name .'.php';  
	}

	require_once('configuration/identification.php');
	require_once('configuration/options.php');
	//require_once('lib/lib_debug.php');
?>