<?php

    include '../connection.php';

    //Bruker autentisering

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

    if(isset($_GET['leggTil'])){

        global $con;

        $username = $_SESSION['username'];
        $emneKode = $_GET['emneKode'];
        $navn = $_GET['navn'];

        $sql2 = "INSERT INTO emner (navn, emneKode, foreleser) VALUES ( '$navn' , '$emneKode' , '$username' )";
    }


    function visEmner() {

        global $con;

        $username = $_SESSION['username'];

        $query = "SELECT emnekode, emnenavn, navn, epost FROM emner, foreleser WHERE foreleser = epost AND foreleser = '$username'";

        $resultat = $con->query($query) or die($con->error);
        
		while($row = $resultat->fetch_assoc()) {
            echo "<tr><td>" . $row['emnekode'] . "</td>
            <td>" . $row['navn'] . "</td><td>" . $row['epost'] . "<td><a href='../henvendelser.php?emnekode=" . $row['emnekode'] . "'>" . "Se meldinger" . "</a></td></tr>";
        }	
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js" ></script>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">

  <title>Legg til emne</title>

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
</head>

<body>

    <header>

        <nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">

            <div id="navbarBasicExample" class="navbar-menu">

                <div class="navbar-start">

                    <a class="navbar-item" href="foreleserHome.php" >HJEM</a>
                    <a class="navbar-item is-active" href="">EMNER</a>
                    <a class="navbar-item" href="finnstillinger.php">INNSTILLINGER</a>

                </div>

                <div class="navbar-end">

                <p id="studentText" class="has-text-centered has-text-white ">Logged in as <strong>Foreleser</strong></p>

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
                <h1 class="subtitle is-2 is-centered">LEGG TIL EMNER:</h1>
            </div>

        </div>

    </div>

    <div class="columns">

        <div class="column is-half " class="column">
    	
    	    <div id="card" class="card">
		  		
  			    <div  class="card-content">
  				
                    <p class="card-header-title is-centered"></p>
                
                    <div class="field">
        
                        <form action= "">
                
                            Emnenavn:  <input type="text" class="input is-primary"  name="navn" pattern="[a-zA-Z0-9]+" minlength="2" maxlength="50"><br>
                            Emnekode:  <input type="text" class="input is-primary"  name="emneKode" pattern="[a-zA-Z0-9]+" minlength="2" maxlength="20"><br>
                            
                            <br>

                            <button name="leggTil" class="button is-primary" class="button is-link"> Legg til </button>      
                
                        </form>
            
                    </div>

                </div>

            </div>

        </div>

        <div class="column is-half" id="tabell" class="column">

        <div id="emnerCard" class="card">

            <table id="emner" class="table">
                <thead>
                    <tr>
                    <th>Emnekode</th>
                    <th>Navn</th>
                    <th>Foreleser</th>
                    <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?= visEmner() ?>
                </tbody>
            </table>

        </div>
        </div>

    </div>

</body>
</html>