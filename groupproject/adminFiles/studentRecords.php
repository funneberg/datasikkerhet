<?php

session_start();

if (!isset($_SESSION['authenticated'])) {
	
	header("../index.php");
	
}


error_reporting(E_ALL & ~E_NOTICE);
include '../connection.php';


function displayStudents(){
  global $dbConn;

  $sql = "SELECT first_name, last_name, studentID, date_of_birth FROM student_table";

  $stmt = $dbConn -> prepare ($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  

  return $records;
}

function countStudents() {
	
	global $dbConn;
	
	$sql = "SELECT COUNT(*) as total FROM student_table";
	$stmt = $dbConn -> prepare ($sql);
  	$stmt->execute();
  	$result = $stmt->fetchColumn();
	
	echo $result;
	
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
        

        $(".delete").on("click", function(event){
  
          if (confirm("Delete info for " + $(this).attr("studentName") + "?")== false){
          event.preventDefault();
          }
        })
  
        
  
      });
  </script>
  
</head>

<body>
<header>
    <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item has-text-white is-3" href="admin.php">Home</a>
		      <a class="navbar-item is-active" href="studentRecords.php">Student Records</a>
			  <a class="navbar-item has-text-white is-3" href="courseRecords.php">Course Records</a>
	
			
			</div>
			<div class="navbar-end">
				<p id="adminText" class="has-text-centered has-text-white">Logged in as <strong>Admin</strong></p>
				<form action="adminLogout.php">
					<button  class="button is-primary has-text-centered ">Log out</button>
				</form>
			</div>	
		   </div>
		</nav>
    </header>   

    <div class="columns">
			
		  <div class="column is-full " class="column">
		  	
		  	<!--Header-->
		  	<div id="header" class="container is-vcentered">
      		<h1 class="subtitle is-2 is-vcentered">Student Records</h1>
    		</div>
		  </div> 
    </div>


    <div class="content">
    	
    	<nav class="level">
  			<!-- Left side -->
  
		  	<div class="level-left">
			    <div class="level-item">
			      <p class="subtitle is-5">Number of students: <?= countStudents()?></p>
			    </div>
			</div>

  			<!-- Right side -->
  			<div class="level-right is-vcentered">
 				<p class="level-item "><a class="level-item" href="addStudent.php"><button class="button  is-primary" class="button is-link">Add student</button></a></p>
  			</div>
</nav>
    	<hr>
    	
    <div class="column is-full">
    <table class="table">
    	
			  <thead>
			    <tr>
			      <th>Student ID</th>
			      <th>First Name</th>
			      <th>Last Name</th>
			      <th>Date of Birth</th>
			      <th>Delete/Update</th>
			    </tr>
			  </thead>
			  
			  <tbody>
			    <?php 
      				$students = displayStudents();

				      for ($i=0; $i < sizeof($students); $i++) { 
				        
						  echo "<tr><td>" . $students[$i]["studentID"]. "</td><td>" .
						  $students[$i]["first_name"] . "</td><td>" . $students[$i]["last_name"]. "</td><td>" . $students[$i]["date_of_birth"] . "</td><td>" .
						  " <a class='delete' studentName = '".$students[$i]['first_name']. "'  href='deleteStudent.php?studentID=".$students[$i]['studentID']."'> Delete </a>" . 
						  " <a href='updateStudent.php?studentID=".$students[$i]['studentID']."'> Update </a>". "</td></tr>";
				      }
			     ?>
			  </tbody>
			 </table>
    </div>
    </div>
    <br>

<hr />




</body>
</html>