<?php

//Bruker autentisering
session_start();

if (!isset($_SESSION['foreleser'])) {
	header("Location: ../hjem.php"); 
}

?>

<!DOCTYPE html>
<html>
<head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
  	
  	<header>
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  	<div id="navbarBasicExample" class="navbar-menu">
		   		<div class="navbar-start">
					<a class="navbar-item is-active">HJEM</a>
					<a class="navbar-item" href="foreleserSider/femner.php">EMNER</a>
					<a class="navbar-item" href="../innstillinger.php">INNSTILLINGER</a>
				</div>

				<div class="navbar-end">
				<p id="studentText" class="has-text-centered has-text-white">Logged in as <strong>Foreleser</strong></p>
				<form action="../logout.php">
					<button  class="button is-primary has-text-centered ">Logg ut</button>
				</form>
			</div>
		   </div>

		</nav>
	</header>
	
	<div class="columns">
			
		<div  class="column is-full" class="column">
		  	
		  	<!--Header-->
    	  	<div class="container is-centered">
      			<h1 class="subtitle is-2 is-centered" >Velkommen</h1>
      			<h2 class="subtitle is-5 is-centered" >Dette er din startside</h2>
    		</div>

		</div>
		  		
	</div>	
		
	<hr>
		

  
  
</body>
  
</html>
