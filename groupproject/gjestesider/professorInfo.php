<!--Professor info-->
<?php

    include '../connection.php';
	
	function professorInfo(){
		
		global $dbConn;
		
		$sql = "SELECT `prof_firstname`, `prof_lastname`, `biography` FROM `professor_table`
				WHERE professorID = " . $_GET['professorID'].";";
				
		$stmt = $dbConn -> prepare ($sql);
		$stmt->execute();
		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r($records);
		
		return $records;
	
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 
 <title>Professor Information </title>
 
 
 
  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
 
<body>
  	
  	<header>
    		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
        		<a class="navbar-item has-text-white" href="courses.php">BACK</a>
			
			</div>
		   </div>
		</nav>
    </header>  
     
    <div class="content">
    	
    	<?php
			$result = professorInfo();
		?>
    	
    	<div id="ProfInfoCard" class="card">
  			<div class="card-content">
    			<p class="title">Professor Information</p>
    			<p class="subtitle"><?= $result[0]['prof_firstname'] ?> <?= $result[0]['prof_lastname'] ?></p>
    			<p ><?= $result[0]['biography'] ?></p>
  			</div>
		</div>
    		 
    </div>
    
    <hr>

  </div>
</body>
</html>