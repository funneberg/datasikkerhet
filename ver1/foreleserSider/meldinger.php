<?php

    include "../connection.php";

	//Brukerautentisering

	//Starter session
	session_start();
	
	global $con;
	
	//Henter studentID/ansattID lagret i session
    $username = $_SESSION['username'];

	//Sjekker igjennom student tabellen:
	$studentabell = "SELECT count(*) as cntStudent from students where studentID = '$username'";
	$resultat1 = mysqli_query($con,$studentabell);
	$row1 = mysqli_fetch_array($resultat1);
	
	//Sjekker igjennom ansatt tabellen:
	$ansatttabell = "SELECT count(*) as cntForeleser from forelesere where ansattID = '$username'";
	$resultat2 = mysqli_query($con,$ansatttabell);
	$row2 = mysqli_fetch_array($resultat2);

	$studentCount = $row1['cntStudent'];
	$ansattCount = $row2['cntForeleser'];

	//Dersom "username" finnes i student tabellen blir brukeren sendt tilbake til startside.
	if ($studentCount > 0){
		header('Location: ../index.php');
  	}

    function visMeldinger() {

        global $con;

        $username = $_SESSION['username'];

		$sql = "SELECT * FROM meldinger WHERE emneKode = " . $_GET['emneKode'] . ";";

		$resultat = mysqli_query($con,$sql);

        while($row = $resultat->fetch_assoc()) {

			echo "<div class='meldingCard' class='card'>
					<div class='meldingCardContent' class='card-content'>
					<p class='title is-centered'>". $row["emneKode"]  . "</p>
            			<p class='subtitle is-centered'>". $row["melding"]  . "</p>
						<footer class='card-footer'>
							<p class='card-footer-item'><span><a class='knapp' >" . "Svar" . "</a></span></p>
						</footer>
					</div>
				</div>";
            
        }	
	}

	if(isset($_GET['svar'])){

		global $con;

		$svar = $_GET['svar'];
		
        
        $sql2 = "INSERT INTO `meldinger` ( `svar` ) VALUES ( '$svar' ) WHERE meldingKode =  ";

	}
		
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meldinger</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
	<script>

		$(document).ready(function() {

			$(".knapp").on("click", function(){

				$("#svar").css("display","inline");

			});

		});

	</script>
	

  </head>
  
  <body>
  	
  	<header>
  		
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item has-text-white is-3" href="foreleserHome.php">HJEM</a>
			  <a class="navbar-item" href="addEmner.php">EMNER</a>
			  <a class="navbar-item" href="fInnstillinger.php">INNSTILLINGER</a>
			
			</div>
			<div class="navbar-end">

					<p id="studentText" class="has-text-centered has-text-white is-vcentered">Logged in as <strong>Foreleser</strong></p>

					<form action="../logout.php">
						<button  class="button is-primary has-text-centered ">Logg ut</button>
					</form>

				</div>
		   </div>
		</nav>
		
	</header>
	
	<div class="columns">
			
		  <div class="column is-full" class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">MELDINGER</h1>
    		</div>
		  </div> 
    </div>


    <div class="content">
		
    	<hr>
    	
		<div class="container">
			
            <?php visMeldinger(); ?>

		</div>

		<hr>

		<div style="display:none;" id="svar" >

			<form>

				<textarea name="svar" placeholder="Skriv svar her:"></textarea>

				<button name="svar" class="button is-primary">SVAR</button>


   			</form>

		</div>	

						

	</div>
	
</body>
  
</html>