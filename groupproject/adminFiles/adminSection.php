<?php

session_start();

if(!isset($_SESSION['authenticated'])) {
	header("Location: index.php"); 
}

echo "Welcome";

?>

<html> 
	
	<body> 
		<li><a href= "adminLogout.php">Logout</a></li>
		</body>
	</html>
