<?php

include 'connection.php';

if(isset($_GET['logginn'])) {

	global $con;	
	
	$id = $_GET['id'];
	$passord = $_GET['passord'];

	if ($id != "" && $passord != "") {

		session_start();

		
		if ($passord == "admin" && $id == "admin") { 

			$_SESSION['admin'] = true;
			header('Location: admin.php');

		}

		else {

			//Sjekker igjennom student tabellen:
			$studentabell = "SELECT count(*) as cntStudent from students where studentID = '$id' AND passord ='$passord'";
			$resultat1 = mysqli_query($con,$studentabell);
			$row1 = mysqli_fetch_array($resultat1);
			
			//Sjekker igjennom ansatt tabellen:
			$ansatttabell = "SELECT count(*) as cntForeleser from forelesere where ansattID = '$id' AND passord ='$passord'";
			$resultat2 = mysqli_query($con,$ansatttabell);
			$row2 = mysqli_fetch_array($resultat2);

			$studentCount = $row1['cntStudent'];
			$ansattCount = $row2['cntForeleser'];

			if ($studentCount > 0){
				$_SESSION["username"] = $id;
				header('Location: studentSider/studentHome.php');
				$studentCount = 0;
			}

			else if ($ansattCount > 0) {
				$_SESSION["username"] = $id;
				
				header('Location: foreleserSider/foreleserHome.php');
				$ansattCount = 0;
			}

			else {
				echo "Invalid username and password";
			}
		
		}
	}
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
				
				<div class="navbar-menu">

					<div class="navbar-start">
						
						<a class="navbar-item is-active">HJEM</a>
						<a class="navbar-item" href="gjesteSider/emner.php">EMNER</a>
					
					</div>

				</div>

			</nav>

		</header>
	
		<div class="columns">
			
		  <div class="column is-half " class="column">
		  	

		  </div>
		  
		  <!--Login Card-->
		  <div class="column is-half" class="has-background-grey-lighter" class="column">
				  
		  <form>
		  	<div id="login_card" class="card">
		  		
  			<div class="card-content">
  				
  			<p class="card-header-title is-centered">Logg in:</p>
		  	
		    <div class="field">
		    	
				<p class="control has-icons-left has-icons-right">
				    <input class="input" type="text" placeholder="AnsattID/StudentID" name="id">
				    <span class="icon is-small is-left">
				    <i class="fas fa-user"></i>
				    </span>
				    <span class="icon is-small is-right"></span>
				</p>

			</div>
				
				<div class="field">

					<p class="control has-icons-left">

						<input class="input" type="password" placeholder="Passord" name="passord">

						<span class="icon is-small is-left"><i class="fas fa-lock"></i></span>

					</p>

				</div>
				
				<div class="field">

				<nav class="level">

					<!-- Left side -->
					<div class="level-left">
					
						<p class="control">
							<button class="button is-primary" name="logginn" id= "loginBtn">Login</button>
						</p>

					</div>

					<div class="level-right">
					
					<p class="control">
						<p class="is-vcentered">Ikke registrert? <a href="registrer.php">Trykk her!</a></p> 
						
					</p>

					</div>

					<br> 

					<h3 name="errorMessage"></h3>

				</form>

					
				</div>
				
		  </div>
		  
		</div>
		</div>
		</div>	
		
		<hr>
		

  
  
  </body>
  
</html>
