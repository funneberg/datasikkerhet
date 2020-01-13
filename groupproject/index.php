
<!DOCTYPE html>
<html>
  <head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
		
		$(document).ready(function() {
			
			function quotes(){
    			
				$.ajax({
						
				method: "GET",
				url: "quoteAPI.php",
				dataType: "json",
				success: function(result,status) {
				
					//alert(result[0].quote);
					
					
						$("#quotes").html(result[0].quote);
						$("#name").html(result[0].author);

					
				}	
				});
			}
			
			quotes();
				
			$("#loginBtn").on("click", function(){
				
			$.ajax({
						
				method: "POST",
				url: "login/confirmLogin.php",
				dataType: "json",
				data: { "password": $("#password").val(),
						"username": $("#username").val() },
				success: function(result,status) {
							  
					if (result == true) {
						location.href = "adminFiles/admin.php"; 	 
						} else {
						$("#errorMessage").html("Wrong Credentials!");	
						}
						}
					});	
					
					});
				}); 
				
		</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    
    
    
    
  </head>
  
  
  <body>
  	
  	<header>
		<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
			
		  <div id="navbarBasicExample" class="navbar-menu">
		    <div class="navbar-start">
		    	
		      <a class="navbar-item is-active">Home</a>
		      <a class="navbar-item" href="guestFiles/departments.php">Departments</a>
		      <a class="navbar-item" href="guestFiles/courses.php">Courses</a>
			
			</div>
		   </div>
		</nav>
	</header>
	
		<div class="columns">
			
		  <div class="column is-half " class="column">
		  	
		  	<!--Header-->
		  	
    	  	<div id="header"  class="container is-vcentered">
      			<h1 class="subtitle is-2 is-vcentered" id="quotes"></h1>
      		<p id="name"></p>
    		</div>
		  </div>
		  
		  <!--Login Card-->
		  <div class="column is-half" class="has-background-grey-lighter" class="column">
		  		
		  	<div id="login_card" class="card">
		  		
  			<div class="card-content">
  				
  			<p class="card-header-title is-centered">Log in:</p>
		  	
		    <div class="field">
		    	
				  <p class="control has-icons-left has-icons-right">
				    <input class="input" type="text" placeholder="Username" id= "username">
				    <span class="icon is-small is-left">
				    <i class="fas fa-user"></i>
				    </span>
				    <span class="icon is-small is-right"></span>
				  </p>
			</div>
				
				<div class="field">
				  <p class="control has-icons-left">
				    <input class="input" type="password" placeholder="Password" id= "password">
				    <span class="icon is-small is-left">
				      <i class="fas fa-lock"></i>
				    </span>
				  </p>
				</div>
				
				<div class="field">
					
				  <p class="control">
				    <button class="button is-primary " id= "loginBtn">Login</button>
				 </p>
				 <br> 
				 <h3 id= "errorMessage"></h3>
				</div>
				
		  </div>
		  
		</div>
		</div>
		</div>	
		
		<hr>
		

  
  
  </body>
  
</html>
