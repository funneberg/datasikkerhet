<?php

session_start();  
	
if (!isset($_SESSION['authenticated'])) {
		
	header("Location: ../index.html"); 
}

include '../connection.php';

if(isset($_GET['formSubmit'])) {
global $dbConn;

    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $date_of_birth = $_GET['date_of_birth'];
    $courseID = $_GET['courseID'];

    $sql = "INSERT INTO `student_table` (`first_name`, `last_name`, `date_of_birth`, `courseID`, `studentID`) 
        VALUES ('$first_name', '$last_name', '$date_of_birth', '$year', '$studentID')";

    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute();

}

function displayStudents(){
  global $dbConn;

  $sql = "SELECT first_name, last_name, studentID FROM student_table";

  $stmt = $dbConn -> prepare ($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $records;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js" ></script>
  <link href="../css/styles.css" rel="stylesheet" type="text/css" />

  <title>Student Records</title>

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
  <script>
  	$(document).ready(function(){
  		
        <?php
		  include("#.php") 
		 ?>
  	});
  </script>
  
</head>

<body>
<header>
    <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item is-active has-text-white subtitle is-6"  href="studentRecords.php">BACK</a>
			  
			</div>
		   </div>
		</nav>
    </header>   

    <div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">Add student</h1>
    		</div>
		  </div> 
    </div>

	<div class="content">
    	
    <div class="column is-full" id="addStudent">
    	
    	<div id="card" class="card">
		  		
		<div  class="card-content">
  				
  			<p class="card-header-title is-centered">Enter information</p>
		  	
		    <div class="field">
			      <form action= "">
			      	
			        First Name: <input type="text" class="input is-primary" name="first_name"><br>
			        Last Name: <input type="text" class="input is-primary" name="last_name"><br>
			        Date of Birth: <input type="text" class="input is-primary" placeholder="yyyy-mm-dd" name="date_of_birth"><br>
			        CourseID: <input type="text" class="input is-primary" name="courseID"><br>
			        <br>
			        <button name="formSubmit" class="button is-primary" class="button is-link"> Add student</button>      
			          
			      </form>
	     		</div>
     		</div>
    	</div>
	</div>
</div>



</body>
</html>