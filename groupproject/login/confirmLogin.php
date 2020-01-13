<?php

session_start();

	if (sha1($_POST['password']) == "2053d551f2308e88a59faaee97b0c5d07d52a597" && $_POST['username'] == "teacheradmin") { //password: admin234
	
		$_SESSION['authenticated'] = true;
		echo "true";
		
	} else {
		
		echo "false";
	}



?>
