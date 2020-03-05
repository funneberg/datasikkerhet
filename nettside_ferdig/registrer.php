<?php

include 'connection.php';

if(isset($_POST['studentSubmit'])) {

  global $con;

  $navn = $_POST['navn'];
  $epost = $_POST['epost'];
  $studieretning = $_POST['studieretning'];
  $kull = $_POST['kull'];

  //Passord:
  $passord1 = $_POST['passord1'];

  $sql1 = "INSERT INTO student (navn, epost, studieretning, kull, passord) VALUES ('$navn', '$epost', '$studieretning', '$kull' , '$passord1')";

  if ($con->query($sql1) === TRUE) {
      echo "Studentbruker opprettet!";
  } 
  else {
      echo "Error: " . $sql1 . "<br>" . $con->error;
  }
}

if(isset($_POST['foreleserSubmit']) && isset($_FILES['bilde'])) {

  echo "Hei";

  global $con;

  $foreleserNavn = $_POST['foreleserNavn'];
  $foreleserEpost = $_POST['foreleserEpost'];

  $target_dir = "bilder/";
  $bilde = basename($_FILES['bilde']['name']);
  $target_file = $target_dir.$bilde;

  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  $check = getimagesize($_FILES["bilde"]["tmp_name"]);

  if($check !== false) {
    echo "Filen er et bilde - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Filen er ikke et bilde. ";
    echo "Bruker ble ikke opprettet.";
    $uploadOk = 0;
    exit();
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Filen ble ikke lastet opp.";
  // if everything is ok, try to upload file
  } else {
    move_uploaded_file($_FILES["bilde"]["tmp_name"], $target_file);
  }

  //Passord:
  $passord2 = $_POST['passord2'];

  $sql1 = "INSERT INTO foreleser (navn, epost, bilde, passord) VALUES ('$foreleserNavn', '$foreleserEpost', '$bilde' , '$passord2')";

  if ($con->query($sql1) === TRUE) {
      echo "Foreleserbruker opprettet!";
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
  <link href="css/styles.css" rel="stylesheet" type="text/css" />

  <title>Registrer</title>

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
</head>

<body>
  <header>
      <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
        
        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            
            <a class="navbar-item is-active has-text-white subtitle is-6"  href="index.php">TILBAKE</a>
          
        </div>
        </div>
      </nav>
  </header>

	<div class="content">

  <div class="columns">
    	
    <div class="column is-half" id="studentReg">
    	
      <div id="studentCard" class="card">

        <div class="column is-half " class="column">
          
          <!--Header-->
          <div id="header"  class="container is-centered">
            <h1 class="subtitle is-2 is-centered">Student</h1>
          </div>

        </div>
		  		
		    <div  class="card-content">
  				
  			  <p class="card-header-title is-centered">Fyll inn informasjon</p>
		  	
		      <div class="field">

			      <form action= "" method="post">
			      	
              <label class="label">Navn</label>
			        <input type="text" class="input is-primary" name="navn">
              <label class="label">E-post</label>
			        <input type="text" class="input is-primary" name="epost">
              <label class="label">Studieretning</label>
			        <input type="text" class="input is-primary" name="studieretning">
              <label class="label">Årskull</label>
              <input type="text" class="input is-primary" name="kull">

              <div class="field is-grouped is-grouped-multiline">
                <label class="label">Passord</label>
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

      <div class="column is-half " class="column">
          
      <!--Header-->
      <div id="header"  class="container is-centered">
            <h1 class="subtitle is-2 is-centered">Foreleser</h1>
      </div>

    </div>
		  		
		    <divclass="card-content">
  				
  			  <p class="card-header-title is-centered">Fyll inn informasjon</p>
		  	
		      <div class="field">

			      <form action= "" method="post" enctype="multipart/form-data">
			      	
              <label class="label">Navn</label>
			        <input type="text" class="input is-primary" name="foreleserNavn">
              <label class="label">E-post</label>
			        <input type="text" class="input is-primary" name="foreleserEpost">
              <label class="label">Bilde</label>
			        <input type="file" class="input is-primary" name="bilde">
  
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