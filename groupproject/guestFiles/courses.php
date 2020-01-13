<?php

	include "../connection.php";
	
	
	
		
		function displayCourses() {
			
		if (!isset($_GET['filterBtn'])) {
			
		
		global $dbConn;	
		
		$sql = "SELECT *
		FROM course_table";
		
		$stmt = $dbConn -> prepare ($sql);
		$stmt->execute();
		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		for ($i = 0; $i < sizeof($records); $i++) {
			
		echo "<tr><td>" . $records[$i]["courseID"]. "</td>
				  <td><a href='courseInfo.php?courseID=" . $records[$i]['courseID'] . "'>" . $records[$i]["course_name"] . "</a></td>
				  <td><a href='professorInfo.php?professorID=" . $records[$i]['professorID'] . "'>" . $records[$i]["professorID"]. "</a></td>
				  <td>" . $records[$i]["department_name"] . "</td></tr>";
		}
	}
		
}
	
	
	function displayDepartments() {
	
	global $dbConn;	
	
	$sql = "SELECT DISTINCT department_name 
	FROM course_table
	ORDER BY department_name";
	
	$stmt = $dbConn -> prepare ($sql);
	$stmt->execute();
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		for ($i = 0; $i < sizeof($records); $i++) {
			echo "<option> ".$records[$i]['department_name']. "</option>";
		}
	}
	
	function displayCourse() {
	global $dbConn;
	$sql = "SELECT DISTINCT courseID
			FROM `course_table`";
	$stmt = $dbConn -> prepare ($sql);
	$stmt->execute();
	$records = $stmt->fetchALL(PDO::FETCH_ASSOC); 
	
	for ($i=0; $i < sizeof($records); $i++) {
		echo "<option> " .$records[$i]["courseID"]." </option>"; 
	}
	
}
	
	
	
	function filterCourses() {
		
		global $dbConn;
		
			if (isset($_GET['filterBtn'])) {
			
			$sql = "SELECT *
			FROM course_table";
			
			if (!empty($_GET['departments'])) {
				$sql = $sql . " AND department_name = '" .$_GET['departments']."'";
				
			}
			
			else {
				echo "No records found";
			}
			
			$stmt = $dbConn -> prepare ($sql);
			$stmt->execute();
			$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				for ($i = 0; $i < sizeof($records); $i++) {
					
					echo "<tr><td>" . $records[$i]["courseID"]. "</td><td>" . $records[$i]["course_name"] . "</td><td>" . $records[$i]["professorID"]. "</td><td>" . $records[$i]["department_name"] . "</td></tr>";
		
				}
					
			}
	
	}

?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    
  </head>
  
  <body>
  	
  	<header>
  		
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item has-text-white is-3" href="../index.php">Home</a>
		      <a class="navbar-item has-text-white is-3" href="departments.php">Departments</a>
		      <a class="navbar-item is-active" href="courses.php">Courses</a>
			
			</div>
		   </div>
		</nav>
		
	</header>
	
	<div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">Course Overview</h1>
    		</div>
		  </div> 
    </div>


    <div class="content">
    	
    	<div class="content">
    	
    	<nav class="level">
  			<!-- Left side -->
		  	<div class="level-left">
			    <div class="level-item">
			      <form action="courses.php" method="POST">
  					
				    	<div class="select">
				    		
				      		<select name="departments">
					        	<option value="">Departments</option>
					        	<?= displayDepartments()?>
				      		</select>
				    	</div>
				    	
				 		<button name="filterBtn" class="button is-primary">Sort courses</button>
				 	
				 	</form>
			      
			    </div>
			</div>

  			<!-- Right side -->
  			<div class="level-right is-vcentered">
  				
  				<div class="level-item is-vcentered">
  					<form action="students.php" method= "GET">
  					
				    	<div class="select">
				    		
				      		<select name="courseID">
					        	<option value=" ">Course ID</option>
					        	<?= displayCourse()?>
				      		</select>
				    	</div>
				    	
				 		<button name="filterBtn" class="button is-primary">Students</button>
				 	</form>
    			</div>
    			
    		
  			</div>
  			
		</nav>
		
    	<hr>
    	
	<div class="container">
		<div class="column">
  					
   	 		<table class="table">
			  <thead>
			    <tr>
			      <th>Course ID</th>
			      <th>Name</th>
			      <th>Professor ID</th>
			      <th>Department</th>
			    </tr>
			  </thead>
			  <tbody>
			      <?= displayCourses()?>
			  </tbody>
			 </table>
  		
  			</div>
  
		</div>
	
	<hr>
	


</body>
  
</html>