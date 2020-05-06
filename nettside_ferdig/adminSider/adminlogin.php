<?php

include '../connection.php';

if(isset($_POST['logginn']) && isset($_POST['username']) && isset($_POST['password'])) {

    global $con;

    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT count(*) as cntAdmin FROM admin WHERE brukernavn = '$username' AND passord = '$password'";

	$result1=mysqli_query($con, $sql);
	
	if (!$result1) {
		printf("Error: %s\n", mysqli_error($con));
		exit();
	}

	$row=mysqli_fetch_array($result1);

    $adminCount = $row['cntAdmin'];


    if ($adminCount > 0) {

        $_SESSION['admin'] = true;
        $_SESSION['username'] = $username;

        header('Location: admin.php');
        $adminCount = 0;
        exit();

    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>(Web-designeren vår dro på ferie)</p>
    <nav>
        <a href="../index.php">Hjem</a>
        <a href="../gjesteSider/emner.php">Emner</a>
    </nav>
    <form method="post">
        <div>
            <labe for="username">Brukernavn:</label><br/>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="20"/>
        </div>
        <div>
            <labe for="password">Passord:</label><br/>
            <input type="password" name="password" pattern="[^'\x22]+" minlength="3" maxlength="25"/>
        </div>
        <!--<input type="submit" name="Logginn" text="Logg inn" />-->
        <button name="logginn" value="Send">Logg inn</button>
    </form>
</body>
</html>