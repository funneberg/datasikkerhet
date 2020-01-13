<?php

	include "../connection.php";

	
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
	
	function displayCourses() {
		
		global $dbConn;	
		
		$sql = "SELECT *
		FROM course_table";
		
		$stmt = $dbConn -> prepare ($sql);
		$stmt->execute();
		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		for ($i = 0; $i < sizeof($records); $i++) {
			
			echo "<tr><td>" . $records[$i]["courseID"]. "</td><td>" . $records[$i]["course_name"] . "</td><td>" . $records[$i]["professorID"]. "</td><td>" . $records[$i]["department_name"] . "</td></tr>";

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
 ?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="css/homepage_style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  
  <body>
  	
  	<header>
  		
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item" href="index.html">Home</a>
		      <a class="navbar-item" href="departments.php">Departments</a>
		      <a class="navbar-item is-active" href="courses.php">Courses</a>
			
			</div>
		   </div>
		</nav>
		
	</header>
	
	<div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">Courses</h1>
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
    	
	<div class="columns">
		
  		
  	</div>
  		
  		<div class="columns">
  			<div class="column">
  				
  				<form action="students.php" method= "GET">
  					
				    	<div class="select">
				    		
				      		<select name="courseID">
					        	<option value=" ">Course ID</option>
					        	<?= displayCourse()?>
				      		</select>
				    	</div>
				    	
				 	<button name="filterBtn" class="button is-link">Students</button>
				 	
  				</form>
  				
               
   	 		<table class="table">
			  <thead>
			    <tr>
			      <th><abbr title="courseID" name = "courseID">ID</abbr></th>
			      <th><abbr title="courseName">Name</abbr></th>
			      <th><abbr title="professorID">Professor</abbr></th>
			      <th><abbr title="departmentName">Department</abbr></th>
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
