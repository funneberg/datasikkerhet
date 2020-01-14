<?php

session_start();

if (!isset($_SESSION['student'])) {
	
	header("../index.php");
	
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  
  <body>
  	
  	<header>
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
			
		      <a class="navbar-item is-active " href="admin.php">Home</a>
		      <a class="navbar-item has-text-white is-3" href="studentRecords.php">Student Records</a>
			  <a class="navbar-item has-text-white is-3" href="courseRecords.php">Course Records</a>
			  
			</div>
			
			<div class="navbar-end">
				<p id="adminText" class="has-text-centered has-text-white">Logged in as <strong>Admin</strong></p>
				<form action="adminLogout.php">
					<button  class="button is-primary has-text-centered ">Log out</button>
				</form>
			</div>
			
		   </div>
		</nav>
	</header>
	
		<div class="columns">
			
		  <div class="column is-half " class="column">
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      			<h1 class="subtitle is-2 is-vcentered">Administration Homepage</h1>
    		</div>
		  </div>
		  		  
		</div>
		
		<hr>
		

  
  
  </body>
  
</html>
