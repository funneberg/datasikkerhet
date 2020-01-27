<?php

    include "../connection.php";

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
		header('Location: ../hjem.php');
  	}
    
	function visEmner() {

		global $con;

		$sql = "SELECT emnekode, emnenavn FROM emner";

		$resultat = mysqli_query($con,$sql);

		while($row = $resultat->fetch_assoc()) {
			echo "<option value=" . $row['emnekode'] . ">" . $row['emnenavn'] . "</option>";
		}	

	}
	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    
  </head>
  
  <body>
  	
  	<header>
  		
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item has-text-white is-3" href="studentHome.php">HJEM</a>
		      <a class="navbar-item is-active" >EMNER</a>
			  <a class="navbar-item" href="sInnstillinger.php">INNSTILLINGER</a>
			
			</div>

			<div class="navbar-end">

			  <p id="studentText" class="has-text-centered has-text-white is-vcentered">Logged in as <strong>Student</strong></p>

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
      		<h1 class="subtitle is-2 is-vcentered">Emne oversikt</h1>
    		</div>
		  </div> 
    </div>


    <div class="content">
    	
    	<nav class="level">
  			<!-- Left side -->
		  	<div  class="level-left">

			  	<form>

			    	<div class="level-item">
					
						<div id="emnerSelect" class="select">

							<select id="emnerDD"  name="dropdownEmner">

								<option>Emner</option>

								<?php visEmner() ?>

							</select>

						</div>

						<div class="level-item">
							<button class="button is-primary" name="filtrer">  Søk  </button>
						</div>

					</div> 
				</form>
			</div>
			

  			<!-- Right side -->
  			<div class="level-right is-vcentered">
  				
  				<div class="level-item is-vcentered">
  					
    			</div>
    			
  			</div>
  			
		</nav>
		
    	<hr>
    	
		<div class="container">

			<div class="column">
						
				<table class="table">

					<thead>
						<tr>
							<th>Emnekode</th>
							<th>Navn</th>
							<th>Foreleser</th>
							<th>Epost</th>
						</tr>
					</thead>
				
				<tbody>
				<tbody>
						<?php

							if(isset($_GET['filtrer'])) {

								global $con;

								$dropdownEmner = $_GET['dropdownEmner'];

								$sql = "SELECT e.*, f.navn FROM emner e LEFT JOIN foreleser f ON (e.foreleser = f.epost) WHERE emnekode = '$dropdownEmner'";

								$result = $con->query($sql) or die($con->error);

								while($row = $result->fetch_assoc()) {
									echo "<tr><td>" . $row["emnekode"] . "</td>
									<td>" . $row["emnenavn"] . "</td>";
									if ($row['foreleser'] != null) {
										echo "<td>" . $row["navn"] . "</td>
										<td>" . $row["foreleser"] . "</td></tr>";
									}
									else {
										echo "</tr>";
									}
								}	
							}
						?>
					</tbody>
					
					
					
				</tbody>
				
				</table>
			
			</div>
  
		</div>
	
	<hr>
	


</body>
  
</html>