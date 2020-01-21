<?php
//Testkommentar
$servername = "localhost";
$username = "root";
$password = 'root';
$dbname = "test";

$con = mysqli_connect($servername,$username,$password,$dbname) or die("Connection Failed.");
echo ("Connection success");

?>
