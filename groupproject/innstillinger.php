<?php

//Bruker autentisering
session_start();

global $con;	
	
  $id = $_SESSION['brukernavn'];
  $gammeltPassord = $_GET['gammelPassord'];
  $passord1 = $_GET['passord1'];
  $passord2 = $_GET['passord2'];


	if ($id != "" && $passord1 != "" && $passord1 != "") {

    //Sjekker igjennom student tabellen:
    $studentabell = "SELECT count(*) as cntStudent from students where studentID = '$id' AND passord ='$passord'";
    $resultat1 = mysqli_query($con,$studentabell);
    $row1 = mysqli_fetch_array($resultat1);

    //Sjekker igjennom ansatt tabellen:
    $ansatttabell = "SELECT count(*) as cntForeleser from forelesere where ansattID = '$id' AND passord ='$passord'";
    $resultat2 = mysqli_query($con,$ansatttabell);
    $row2 = mysqli_fetch_array($resultat2);


    $studentCount = $row1['cntStudent'];
    $ansattCount = $row2['cntForeleser'];



    if ($studentCount > 0){
      $sql1 = "INSERT INTO `forelesere`(`ansattID`, `navn`, `epost`, `bilde` , `passord` ) VALUES ('$ansattID', '$foreleserNavn', '$foreleserEpost', '$bildeLink' , '$passord2')";

      if ($con->query($sql1) === TRUE) {
        echo "Passord reset ";
      } 
      else {
        echo "Error: " . $sql1 . "<br>" . $con->error;
      }

    }

    else if ($ansattCount > 0) {
      
    }

else {
        echo "Invalid username and password";
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

  <title>Instillinger </title>

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
        
      <div class="column">
    
        <!--Header-->
        <div id="header"  class="container is-centered">
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