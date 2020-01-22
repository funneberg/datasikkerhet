<?php

  include '../connection.php';

  //Brukerautentisering

	//Starter session
	session_start();
	
  global $con;
  
	//Henter studentID/ansattID lagret i session
  $username = $_SESSION['username'];

	//Sjekker igjennom "students tabellen":
	$studentabell = "SELECT count(*) as cntStudent from students where studentID = '$username'";
	$resultat1 = mysqli_query($con,$studentabell);
	$row1 = mysqli_fetch_array($resultat1);
	
	//Sjekker igjennom "foreleser tabellen":
	$forelesertabell = "SELECT count(*) as cntForeleser from forelesere where ansattID = '$username'";
	$resultat2 = mysqli_query($con,$forelesertabell);
	$row2 = mysqli_fetch_array($resultat2);

	$studentCount = $row1['cntStudent'];
	$foreleserCount = $row2['cntForeleser'];

	//Dersom "username" finnes i "foreleser tabellen" blir brukeren sendt tilbake til startside.
	if ($foreleserCount > 0){
		header('Location: ../hjem.php');
  }
    

  if(isset($_GET['byttPassord'])) {

    global $con;

    $username = $_SESSION['username'];
    $gammeltPassord = $_GET['gammeltPassord'];
    $passord1 = $_GET['passord1'];
    $passord2 = $_GET['passord2'];



    $sjekkStudent = " SELECT passord FROM students  WHERE passord = '$gammeltPassord' AND '$username' = studentID";

    if(mysqli_query( $con, $sjekkStudent )){

      echo "Funker student";

      $sql = "UPDATE students SET passord = '$passord1' WHERE courseID = '$username'";

      mysqli_query ( $con, $sql );

    } 
    
    else{
      echo "ERROR: Could not able to execute $sjekkStudent. " . mysqli_error($con);
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

  <title>Instillinger </title>

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
</head>

<body>

<header>

  <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">

    <div id="navbarBasicExample" class="navbar-menu">

      <div class="navbar-start">

        <a class="navbar-item" href="studentHome.php">HJEM</a>
        <a class="navbar-item" href="sEmner.php">EMNER</a>
        <a class="navbar-item is-active" href="sInnstillinger.php">INNSTILLINGER</a>

      </div>

      <div class="navbar-end">

        <p id="studentText" class="has-text-centered has-text-white is-vcentered">Logged in as <strong>Foreleser</strong></p>

        <form action="logout.php">
          <button  class="button is-primary has-text-centered ">Logg ut</button>
        </form>

      </div>

    </div>

  </nav>

</header>
      
<div class="columns">
        
  <div class="column">

    <!--Header-->
    <div class="container is-centered">

      <h1 class="subtitle is-2 is-centered">INNSTILLINGER</h1>

    </div>

  </div>

</div>

  <div class="content">

    <div class="columns">
        
        <div class="column is-one-third" >
            
          <div id="byttpassordCard" class="card">
                        
            <div class="card-content">
                        
              <p class="card-header-title is-centered">Bytt passord:</p>
                    
              <form action= "">

                <div class="field">
                  
                  <label class="label">Skriv inn gammelt passord</label>
                  <input type="password" class="input is-primary" name="gammeltPassord"><br>

                  <br>

                  <label class="label">Skriv inn nytt passord</label>
                  <input type="password" class="input is-primary" name="passord1"><br>
                      
                  <br>

                  <label class="label is-centered">Gjenta passord</label>
                  <input type="password" class="input is-primary" name="passord2">
              
                </field>

                <br><br>

                <field class="field is-grouped is-grouped-centered" >
                  <button name="byttPassord" class="button is-primary is-centered" >Bytt</button>     
                </field>

              </form>

            </div>

          </div>

        </div>
      </div>
    </div>
</body>
</html>