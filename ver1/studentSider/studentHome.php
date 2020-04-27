<?php

	include '../connection.php';

	//Brukerautentisering

	//Starter session
	session_start();
	
	global $con;
	//Henter studentID/ansattID lagret i session
    $username = $_SESSION['username'];

	//Sjekker igjennom "students tabellen":
	$studentabell = "SELECT count(*) as cntStudent from student where epost = '$username'";
	$resultat1 = mysqli_query($con,$studentabell);
	$row1 = mysqli_fetch_array($resultat1);
	
	//Sjekker igjennom "foreleser tabellen":
	$forelesertabell = "SELECT count(*) as cntForeleser from foreleser where epost = '$username'";
	$resultat2 = mysqli_query($con,$forelesertabell);
	$row2 = mysqli_fetch_array($resultat2);

	$studentCount = $row1['cntStudent'];
	$foreleserCount = $row2['cntForeleser'];

	//Dersom "username" finnes i "foreleser tabellen" blir brukeren sendt tilbake til startside.
	if ($foreleserCount > 0){
		header('Location: ../index.php');
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
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
  	
  	<header>
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  	<div id="navbarBasicExample" class="navbar-menu">
		   		<div class="navbar-start">
					<a class="navbar-item is-active">HJEM</a>
					<a class="navbar-item" href="sEmner.php">EMNER</a>
					<a class="navbar-item" href="sInnstillinger.php">INNSTILLINGER</a>
				</div>

				<div class="navbar-end">
				<p id="studentText" class="has-text-centered has-text-white">Logged in as <strong>Student</strong></p>
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
