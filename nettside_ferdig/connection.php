<?php

/*
$servername = "localhost";
$usernameRoot = "root";
$passwordRoot = "root";

$usernameRead = "read";
$passwordRead = "lysglimt";

$usernameAdd = "add";
$passwordAdd = "blokkade";
$dbname = "datasikkerhet";

$conRoot = mysqli_connect($servername,$usernameRoot,$passwordRoot,$dbname) or die("Connection Failed...");
$conAdd = mysqli_connect($servername,$usernameAdd,$passwordAdd,$dbname) or die("Connection Failed...");
$conRead mysqli_connect($servername,$usernameRead,$passwordRead,$dbname) or die("Connection Failed...");
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datasikkerhet_test";

$con = mysqli_connect($servername,$username,$password,$dbname) or die("Connection Failed...");


?>
