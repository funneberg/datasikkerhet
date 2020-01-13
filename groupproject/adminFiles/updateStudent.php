<?php

session_start();  
	
if (!isset($_SESSION['authenticated'])) {
		
	header("Location: ../lab9/index.php"); 
		
}

include '../connection.php';


if(isset($_GET['formSubmit'])){
	
  $first_name = $_GET["first_name"];
  $last_name = $_GET["last_name"];
  $date_of_birth = $_GET["date_of_birth"];
  $courseID = $_GET["courseID"];
  $studentID = $_GET["studentID"];
  $sql = "UPDATE student_table SET 
      first_name= '$first_name', last_name = '$last_name',  date_of_birth = '$date_of_birth', courseID = '$courseID' 
      WHERE studentID = $studentID";
      $stmt = $dbConn -> prepare ($sql);
     $stmt->execute();
	 
  }
 
 
 
 function getStudentInfo(){
   global $dbConn;
   
 $sql = 'SELECT * FROM student_table WHERE studentID = ' . $_GET["studentID"];
 $stmt = $dbConn -> prepare ($sql);
 $stmt->execute();
 $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //print_r($records);
 return $records;
 }
 
 $studentInfo = getStudentInfo();
 

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

  <title>Update Student Records</title>

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
		    	
        		<a class="navbar-item has-text-white" href="studentRecords.php">BACK</a>
			
			</div>
		   </div>
		</nav>
    </header>   
    
<div class="content">
    <div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header"  class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">Update Student Record</h1>
    		</div>
		  </div> 
    </div>
    
    <div id="card" class="card">
		  		
		<div  class="card-content">
  				
  			<p class="card-header-title is-centered">Enter information here</p>
		  	
		    <div class="field">
		    	
    			<form action= "">

			    First Name: <input type="text" class="input is-primary" name="first_name" value="<?= $studentInfo[0]["first_name"] ?>">
			    Last Name: <input type="text" class="input is-primary" name="last_name" value="<?= $studentInfo[0]["last_name"] ?>">
			    Date of Birth: <input type="text" class="input is-primary" name="date-of-birth" value="<?= $studentInfo[0]["date_of_birth"] ?>">
			    Course ID: <input type="text" class="input is-primary" name="courseID" value="<?= $studentInfo[0]["courseID"] ?>">
			    <br>
			    
			    <input type="hidden" name="studentID" value="<?= $studentInfo[0]["studentID"]?>">
				<br>
				<button name="formSubmit" class="button is-primary"> Update student record </button>      
   
				</form>
  			</div>
		</div>
	</div>
</body>
</html>