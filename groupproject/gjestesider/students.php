
<?php
	include "../connection.php";

function filterCourses() {
		
		global $dbConn;
		
		
		$sql = "SELECT * FROM student_table NATURAL JOIN course_table WHERE 1 ";
		
		if (!empty($_GET['courseID'])) {
		$sql = $sql . " AND courseID = '" .$_GET['courseID']."'";
			
		}
		
		$stmt = $dbConn -> prepare ($sql);
		$stmt->execute();
		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
			return $records;	
}

function displayClass() {
	
	global $dbConn;	
	
	$sql = "SELECT course_name FROM `course_table`";
	
	$stmt = $dbConn -> prepare ($sql);
	$stmt->execute();
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!empty($_GET['courseID'])) {
		$sql = $sql . " WHERE courseID = '" .$_GET['courseID']."'";
			
			
		}
		
		
		
			
		
	}
	
?> 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  
  <body>
  	
  	<header>
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
    	
			
		  <div class="column  " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      			<h1 class="subtitle is-2 is-vcentered">Students</h1>
    		</div>
		  
    </div>
    
    <hr>
	
	<h3 class="subtitle is-2 is-vcentered"><?= displayClass() ?></h3>
		
	  <table class="table">
			  <thead>
				    <tr>
				      <th>First Name</th>
				      <th>Last Name</th>
				      <th>Course ID</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
			   
					    $records = filterCourses();
					
						for ($i = 0; $i < sizeof($records); $i++) {
							
						echo "<tr><td>" . $records[$i]["first_name"]. "</td><td>" . $records[$i]["last_name"] . "</td><td>" . $records[$i]["courseID"] . "</td><td>" ;	
						}
				     ?> 
		  	</tbody>
		</table>
  		
  			</div>
  </body>
  
</html>
