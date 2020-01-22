<?php

	include "../connection.php";
		
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
		    	
		      <a class="navbar-item has-text-white is-3" href="../hjem.php">HJEM</a>
		      <a class="navbar-item is-active" href="emner.php">EMNER</a>
			
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
			<div class="level-left">
				<div class="level-item">
					<div class="field has-addons">

						<form	>

						
							<div class="control">
								<input class="input" type="text" name="pinKode" placeholder="PIN Kode - 0000">
							</div>

							<div class="control">
								<button name="sok">Søk</button>
							</div>

						</form>	
						

					</div>
				</div>
			</div>

			<!-- Right side -->
			<div class="level-right is-vcentered">
				
				<div class="level-item is-vcentered"></div>
			
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
						<th>Foreleser ID</th>
						<th>	</th>
						</tr>
					</thead>

					<tbody>
						<?php

							if(isset($_GET['sok'])) {

								global $con;

								$pinKode = $_GET['pinKode']; 

								$sql = "SELECT * FROM emner WHERE $pinKode = PIN ";

								$resultat = mysqli_query($con,$sql);

								while($row = $resultat->fetch_assoc()) {
									echo "<tr><td>" . $row["emneKode"] . "</td>
									<td>" . $row["navn"] . "</td>
									<td>" . $row["foreleserNavn"] . "</td>
									<td>" . $row["foreleserID"] . "<td><a href='tilbakemeldinger.php'>" . "Se tilbakemeldinger" . "</a></td></tr>";
								}	
							}
						?>
					</tbody>
				</table>
			
			</div>
	
		</div>
	
		<hr>				

	</div>
	


</body>
  
</html>