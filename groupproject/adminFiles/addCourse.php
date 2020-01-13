<?php

session_start();

if (!isset($_SESSION['authenticated'])) {
	
	header("../index.php");
	
}


error_reporting(E_ALL & ~E_NOTICE);

include '../connection.php';

if(isset($_GET['formSubmit'])){
global $dbConn;
    
    $courseID = $_GET['courseID'];
    $course_name = $_GET['course_name'];
    $professorID = $_GET['professorID'];
    $department_name = $_GET['department_name'];

    $sql = "INSERT INTO `course_table` (`courseID`, `course_name`, `professorID`, `department_name`) 
        VALUES ('$courseID', '$course_name', '$professorID', '$department_name')";

    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute();

}

function displayCourses(){
  global $dbConn;

  $sql = "SELECT course_name, courseID, professorID, department_name FROM course_table";

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

  <title>Students</title>

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
		    	
			  <a class="navbar-item is-active has-text-white subtitle is-6"  href="courseRecords.php">BACK</a>
			  
			</div>
		   </div>
		</nav>
    </header>   

    <div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-centered">
      			<h1 class="subtitle is-2 is-centered">Add course</h1>
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
		      	
		      	Course ID: <input type="text" class="input is-primary" placeholder="###" name="courseID"><br>
		        Course Name: <input type="text" class="input is-primary"  name="course_name"><br>
		        ProfessorID: <input type="text" class="input is-primary" name="professorID"><br>
		        Department: <input type="text" class="input is-primary"  name="department_name"><br>
		        
		        <br>
		        <button name="formSubmit" class="button is-primary" class="button is-link"> Add Course </button>      
		          
		      </form>
		      
	      	</div>
    	</div>
      
    </div>



    </div>



</body>
</html>