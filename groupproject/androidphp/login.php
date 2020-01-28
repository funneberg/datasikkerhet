<?php

include "connection.php";

$response = array();
if(isset($_POST['email']) && isset($_POST['password'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$stmt = $conn->prepare("SELECT navn, studieretning, kull FROM student WHERE epost = ? AND passord = ?");
	$stmt->bind_param("ss",$email, $password);
	$stmt->execute();
	$stmt->bind_result($db_name, $db_fieldOfStudy, $db_year);
	$stmt->store_result();
	$stmt->fetch();

	if($stmt->num_rows > 0){
		$response['error'] = false;
		$response['message'] = "Du er logget inn";
        $response['name'] = $db_name;
        $response['email'] = $email;
        $response['fieldOfStudy'] = $db_fieldOfStudy;
        $response['year'] = $db_year;
	} else{
		$response['error'] = false;
		$response['message'] = "Feil epost eller passord";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Alle feltene må fylles ut";
}
echo json_encode($response);

?>