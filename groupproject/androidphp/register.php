<?php

include "connection.php";

$response = array();
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['fieldOfStudy']) && isset($_POST['year']) && isset($_POST['password'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $fieldOfStudy = $_POST['fieldOfStudy'];
    $year = $_POST['year'];
    $password = $_POST['password'];

	$sql_query1 = $conn->prepare("SELECT * FROM student WHERE epost = ?");
	$sql_query1->bind_param("s",$email);
	$sql_query1->execute();
    $sql_query1->store_result();

    $sql_query2 = $conn->prepare("SELECT * FROM foreleser WHERE epost = ?");
	$sql_query2->bind_param("s",$email);
	$sql_query2->execute();
    $sql_query2->store_result();

	if($sql_query1->num_rows > 0 || $sql_query2->num_rows > 0){
		$response['error'] = false;
		$response['message'] = "Brukeren er allerede registrert";
	} else{
		$stmt = $conn->prepare("INSERT INTO student (navn, epost, studieretning, kull, passord) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssis", $name, $email, $fieldOfStudy, $year, $password);
		$result = $stmt->execute();
		if($result){
			$response['error'] = false;
			$response['message'] = "Bruker opprettet";
		} else {
			$response['error'] = false;
			$response['message'] = "Det oppstod et problem";
        }
    }
} else{
	$response['error'] = true;
	$response['message'] = "Alle feltene må fylles ut";
}
print(json_encode($response));

?>