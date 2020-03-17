<?php

  include '../connection.php';

  //Brukerautentisering

	//Starter session
	session_start();
	
	global $con;
	//Henter studentID/ansattID lagret i session
    $username = $_SESSION['username'];

	//Sjekker igjennom student tabellen:
	$studentabell = "SELECT count(*) as cntStudent from student where epost = '$username'";
	$resultat1 = mysqli_query($con,$studentabell);
	$row1 = mysqli_fetch_array($resultat1);
	
	//Sjekker igjennom ansatt tabellen:
	$ansatttabell = "SELECT count(*) as cntForeleser from foreleser where epost = '$username'";
	$resultat2 = mysqli_query($con,$ansatttabell);
	$row2 = mysqli_fetch_array($resultat2);

	$studentCount = $row1['cntStudent'];
	$ansattCount = $row2['cntForeleser'];

	//Dersom "username" finnes i student tabellen blir brukeren sendt tilbake til startside.
	if ($studentCount > 0){
		header('Location: ../index.php');
  }
  
  //Dersom knappen for "Bytt passord" er trykket på utføres denne koden.
  if(isset($_GET['byttPassord'])) {

    global $con;

    $username = $_SESSION['username'];
    $gammeltPassord = $_GET['gammeltPassord'];
    $passord1 = $_GET['passord1'];
    $passord2 = $_GET['passord2'];

    $sjekk = "SELECT passord FROM foreleser WHERE passord = '$gammeltPassord'  AND epost = '$username'";

    $result = mysqli_query( $con, $sjekk);

    $row = mysqli_fetch_array($result);

    if ($row[0] == $gammeltPassord) {
      if ($passord1 == $passord2) {
        
        $sql = "UPDATE foreleser SET passord = '$passord1' WHERE epost = '$username'";

        if (mysqli_query( $con, $sql)) {
          echo "Passord oppdatert";
        }
        else {
          echo "Passordet ble ikke oppdatert";
        }
      }
      else {
        echo "Nytt passord var feil";
      }
    }
    else {
      echo "Feil passord";
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

        <a class="navbar-item" href="foreleserHome.php">HJEM</a>
        <a class="navbar-item" href="addEmner.php">EMNER</a>
        <a class="navbar-item is-active" href="fInnstillinger.php">INNSTILLINGER</a>

      </div>

      <div class="navbar-end">

        <p id="studentText" class="has-text-centered has-text-white is-vcentered">Logged in as <strong>Foreleser</strong></p>

        <form action="../logout.php">
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
                  <input type="password" class="input is-primary" name="gammeltPassord" pattern="[^'\x22]+" minlength="2" maxlength="25"><br>

                  <br>

                  <label class="label">Skriv inn nytt passord</label>
                  <input type="password" class="input is-primary" name="passord1" pattern="[^'\x22]+" minlength="2" maxlength="25"><br>
                      
                  <br>

                  <label class="label is-centered">Gjenta passord</label>
                  <input type="password" class="input is-primary" name="passord2"pattern="[^'\x22]+" minlength="2" maxlength="25">
              
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