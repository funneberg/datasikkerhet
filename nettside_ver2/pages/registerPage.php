<!DOCTYPE html>
<html lang="no">
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

        <?php include_once("components/navbar_fancy.php") ?>

    </header>

	<div class="content">

        <div class="columns">
    	
            <!-- Studentregistrering -->
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

			            <form method="post">
			      	
                            <label class="label">Navn</label>
			                <input type="text" class="input is-primary" name="name" />

                            <label class="label">E-post</label>
			                <input type="text" class="input is-primary" name="email" />
              
                            <label class="label">Studieretning</label>
			                <input type="text" class="input is-primary" name="fieldOfStudy" />

                            <label class="label">Årskull</label>
                            <input type="number" class="input is-primary" name="year">

                            <div class="field is-grouped is-grouped-multiline">

                                <label class="label">Passord</label>
                                <input type="password" class="input is-primary " name="password">

                            </div>

                            <button name="studentSubmit" class="button is-primary" class="button is-link"> Registrer</button>     
                            <p>Er du allerede registrert? <a href="index.php">Logg inn her!</a></p> 
			          
			            </form>

	     		    </div>

     	        </div>

            </div>

        </div>

        <!-- Foreleserregistrering -->
        <div class="column is-half" id="foreleserReg">
            
            <div id="foreleserCard" class="card">

                <div class="column is-half " class="column">
            
                    <!--Header-->
                    <div id="header"  class="container is-centered">
                        <h1 class="subtitle is-2 is-centered">Foreleser</h1>
                    </div>

                </div>
                    
                <div class="card-content">
                    
                    <p class="card-header-title is-centered">Fyll inn informasjon</p>
                
                    <div class="field">

                        <form action= "" method="post" enctype="multipart/form-data">
                        
                            <label class="label">Navn</label>
                            <input type="text" class="input is-primary" name="name" />

                            <label class="label">E-post</label>
                            <input type="text" class="input is-primary" name="email" />

                            <label class="label">Bilde</label>
                            <input type="file" class="input is-primary" name="password" />
    
                            <br>

                            <div class="field">

                                <label class="label">Passord</label>  
                                <input type="password" class="input is-primary " name="passord2" />

                            </div>

                            <button name="lecturerSubmit" class="button is-primary" class="button is-link"> Registrer</button>     
                            <p>Er du allerede registrert? <a href="index.php">Logg inn her!</a></p> 
                        
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>