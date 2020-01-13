<?php

session_start();

if (!isset($_SESSION['authenticated'])) {
	
	header("../index.php");
	
}


include '../connection.php';


if(isset($_GET['formSubmit'])){//is form submitted?

  $courseID = $_GET['courseID'];
    $course_name = $_GET['course_name'];
    $professorID = $_GET['professorID'];
    $department_name = $_GET['department_name'];

  $sql = "UPDATE course_table SET 
      courseID= '$courseID', course_name = '$course_name',  professorID = '$professorID', department_name = '$department_name' 
      WHERE courseID = $courseID";
      $stmt = $dbConn -> prepare ($sql);
     $stmt->execute();
  }
 
 
 
 function getCourseInfo(){
   global $dbConn;
   
 $sql = 'SELECT * FROM course_table WHERE courseID = ' . $_GET["courseID"];
 $stmt = $dbConn -> prepare ($sql);
 $stmt->execute();
 $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //print_r($records);
 return $records;
 }
 
 $courseInfo = getCourseInfo();
 

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

  <title>Update Course Records</title>

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
		    	
        <a class="navbar-item has-text-white subtitle is-6" href="courseRecords.php">BACK</a>
		      
			
			</div>
		   </div>
		</nav>
    </header> 
      
<div class="content">
    <div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      			<h1 class="subtitle is-2 is-vcentered">Update Course Record</h1>
    		</div>
    		
		  </div> 
    </div>
    
    <div id="card" class="card">
		  		
  		<div  class="card-content">
  				
  			<p class="card-header-title is-centered">Enter information</p>
		  	
		    <div class="field">
    
    			<form action= "">

				    Course ID: <input type="text" class="input is-primary" name="courseID" value="<?= $courseInfo[0]["courseID"] ?>">
				    Course Name: <input type="text" class="input is-primary" name="course_name" value="<?= $courseInfo[0]["course_name"] ?>">
				    Professor ID: <input type="text" class="input is-primary" name="professorID" value="<?= $courseInfo[0]["professorID"] ?>">
				    Department Name: <input type="text" class="input is-primary" name="department_name" value="<?= $courseInfo[0]["department_name"] ?>">
				    <br>
				    
					<button name="formSubmit" class="button is-primary"> Update </button>  
					
				</form>
			</div>
		</div>
	</div>    
   
	
  </div>
</body>
</html>