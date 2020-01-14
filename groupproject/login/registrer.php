<?php

include '../connection.php';

if(isset($_GET['studentSubmit'])) {

  global $con;

  $studentID = $_GET['studentID'];
  $navn = $_GET['navn'];
  $epost = $_GET['epost'];
  $studieretning = $_GET['studieretning'];
  $kull = $_GET['kull'];

  //Passord:
  $passord1 = $_GET['passord1'];

  $sql1 = "INSERT INTO `students`(`studentID`, `navn`, `epost`, `studieretning`, `kull` , `passord` ) VALUES ('$studentID', '$navn', '$epost', '$studieretning', '$kull' , '$passord1')";

  if ($con->query($sql1) === TRUE) {
      echo "New student created successfully";
  } 
  else {
      echo "Error: " . $sql1 . "<br>" . $con->error;
  }
}

if(isset($_GET['foreleserSubmit'])) {

  global $con;

  $ansattID = $_GET['ansattID'];
  $foreleserNavn = $_GET['foreleserNavn'];
  $foreleserEpost = $_GET['foreleserEpost'];
  $bildeLink = $_GET['bildeLink'];

  //Passord:
  $passord2 = $_GET['passord2'];

  $sql1 = "INSERT INTO `forelesere`(`ansattID`, `navn`, `epost`, `bilde` , `passord` ) VALUES ('$ansattID', '$foreleserNavn', '$foreleserEpost', '$bildeLink' , '$passord2')";

  if ($con->query($sql1) === TRUE) {
      echo "New foreleser created successfully";
  } 
  else {
      echo "Error: " . $sql1 . "<br>" . $con->error;
  }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
  <link href="../css/styles.css" rel="stylesheet" type="text/css" />

  <title>Registrer</title>

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
</head>

<body>
  <header>
      <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
        
        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            
            <a class="navbar-item is-active has-text-white subtitle is-6"  href="../index.php">TILBAKE</a>
          
        </div>
        </div>
      </nav>
  </header>   

  <div class="columns">
        
    <div class="column is-half " class="column">
          
      <!--Header-->
      <div id="header"  class="container is-centered">
            <h1 class="subtitle is-2 is-centered">Student</h1>
      </div>

    </div>

    <div class="column is-half " class="column">
          
      <!--Header-->
      <div id="header"  class="container is-centered">
            <h1 class="subtitle is-2 is-centered">Foreleser</h1>
      </div>

    </div>

  </div>

	<div class="content">

  <div class="columns">
    	
    <div class="column is-half" id="studentReg">
    	
      <div id="studentCard" class="card">
		  		
		    <div  class="card-content">
  				
  			  <p class="card-header-title is-centered">Fyll inn informasjon</p>
		  	
		      <div class="field">

			      <form action= "">
			      	
              <label class="label">Student ID</label>
			        <input type="text" class="input is-primary" placeholder="ABC1234" name="studentID"><br>
              <label class="label">Navn</label>
			        <input type="text" class="input is-primary" name="navn">
              <label class="label">E-post</label>
			        <input type="text" class="input is-primary" name="epost">
              <label class="label">Studieretning</label>
			        <input type="text" class="input is-primary" name="studieretning">
              <label class="label">Årskull</label>
              <input type="text" class="input is-primary" name="kull"><br>
			        <br>

              <div class="field is-grouped is-grouped-multiline">
                        
                <input type="password" class="input is-primary " name="passord1">

              </div>

              <button name="studentSubmit" class="button is-primary" class="button is-link"> Registrer</button>     
              <p>Er du allerede registrert? <a href="../index.php">Logg inn her!</a></p> 
			          
			      </form>

	     		</div>
     	  </div>
      </div>
    </div>

    <div class="column is-half" id="foreleserReg">
    	
      <div id="foreleserCard" class="card">
		  		
		    <div  class="card-content">
  				
  			  <p class="card-header-title is-centered">Fyll inn informasjon</p>
		  	
		      <div class="field">

			      <form action= "">
			      	
              <label class="label">Ansatt ID</label>
			        <input type="text" class="input is-primary" placeholder="ABC1234" name="ansattID"><br>
              <label class="label">Navn</label>
			        <input type="text" class="input is-primary" name="foreleserNavn">
              <label class="label">E-post</label>
			        <input type="text" class="input is-primary" name="foreleserEpost">
              <label class="label">Bilde link</label>
			        <input type="text" class="input is-primary" name="bildeLink">
  
			        <br>

              <div class="field">
              <label class="label">Passord</label>  
                <input type="password" class="input is-primary " name="passord2">

              </div>

              <button name="foreleserSubmit" class="button is-primary" class="button is-link"> Registrer</button>     
              <p>Er du allerede registrert? <a href="../index.php">Logg inn her!</a></p> 
			          
			      </form>

	     		</div>
     	  </div>
      </div>
  </div>

</div>

</body>
</html>