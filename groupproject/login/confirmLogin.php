<?php

session_start();

	if (sha1($_POST['password']) == "2053d551f2308e88a59faaee97b0c5d07d52a597" && $_POST['username'] == "teacher") { //password: admin234
	
		$_SESSION['teacher'] = true;
		echo true;
		
	} 

	*else if (sha1($_POST['password']) == "9a4f56e2cf3ea0d3ebda5661cfa3865dd2183d7d" && $_POST['username'] == "student") { //password: student234
	
		$_SESSION['student'] = true;
		echo "true";
		
	}
	
	else {
		
		echo "false";
	}



?>
