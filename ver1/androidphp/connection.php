<?php

$conn = new mysqli("localhost", "root", "skosaalen!", "datasikkerhet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>