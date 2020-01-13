<?php

    include '../connection.php';
	
	function courseInfo(){
		
		global $dbConn;
		
		$sql = "SELECT `course_name`, `department_name`, `summary` FROM `course_table`
				WHERE courseID = " . $_GET['courseID'] . ";";
				
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
 
  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 
  <title>Course Information</title>
  
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
 
  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
 
<body>
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
    		$result = courseInfo();
    	?>
    	
    	<div id="courseInfoCard" class="card">
  			<div class="card-content">
    			<p class="title">Course Information</p>
    			<p class="subtitle"><?= $result[0]['course_name'] ?></p>
    			<p ><?= $result[0]['summary'] ?></p>
  			</div>
  			
  			
  			
  			<footer class="card-footer">
    			<p class="card-footer-item"><?= $result[0]['department_name'] ?></p>
    		</footer>
		</div>
    		 
    </div>
    
    <hr>

  </div>
</html>