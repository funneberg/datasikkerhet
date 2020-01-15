<?php

    include "../connection.php";

    //Bruker autentisering
    session_start();

    if (!isset($_SESSION['student'])) {
        header("Location: ../hjem.php"); 
    }
    



		
	function visEmner() {
			
		global $con;	
		
		$sql = "SELECT * FROM emner ";

		$resultat = mysqli_query($con,$sql);

		$array = array();
		while($row = mysqli_fetch_assoc($resultat)){
			$array[] = $row;
		}
		
		return $array;	
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
    	
    	<div class="content">
    	
    	<nav class="level">
  			<!-- Left side -->
		  	<div class="level-left">
			    <div class="level-item">
			      
			    </div>
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
			      <th>Foreleser ID</th>
			    </tr>
			  </thead>
			  <tbody>
			  	
			    <?php 
			    
					$row = visEmner();
					  
					for ($i=0; $i < sizeof($row); $i++) { 
					echo "<tr><td>" . $row[$i]["emneKode"]. "</td>
					<td>" . $row[$i]["navn"] . "</td>
					<td>" . $row[$i]["foreleserNavn"]. "</td>
					<td>" . $row[$i]["foreleserID"] . "</td></tr>";
					}
	      		?>	
			    
			     
			  </tbody>
			 </table>
  		
  			</div>
  
		</div>
	
	<hr>
	


</body>
  
</html>