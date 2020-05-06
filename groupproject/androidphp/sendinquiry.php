<?php

include "connection.php";

$response = array();
if(isset($_POST['emailFrom']) && isset($_POST['emailTo']) && isset($_POST['coursecode']) && isset($_POST['message'])){
    $emailFrom = $_POST['emailFrom'];
    $emailTo = $_POST['emailTo'];
    $coursecode = $_POST['coursecode'];
	$message = $_POST['message'];
	$stmt = $conn->prepare("INSERT INTO henvendelse (avsender, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss",$emailFrom, $emailTo, $coursecode, $message);
    $stmt->execute();
    $stmt->fetch();
    $response['error'] = false;
    $response['message'] = "Comment sent!";
} else {
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);

?>