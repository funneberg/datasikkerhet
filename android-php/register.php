<?php

include "connection.php";

$response = array();
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['fieldOfStudy']) && isset($_POST['year']) && isset($_POST['password'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $fieldOfStudy = $_POST['fieldOfStudy'];
    $year = $_POST['year'];
    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT)
    $password = $_POST['password'];
	$sql = $conn->prepare("SELECT * FROM student WHERE epost = ?");
	$sql->bind_param("s",$email);
	$sql->execute();
	$sql->store_result();
 
	if($sql->num_rows > 0){
		$response['error'] = false;
		$response['message'] = "User already registered";
	} else{
		$stmt = $conn->prepare("INSERT INTO student (navn, epost, studieretning, kull, passord) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssis", $name, $email, $fieldOfStudy, $year, $password);
		$result = $stmt->execute();
		if($result){
			$response['error'] = false;
			$response['message'] = "User Registered Successfully";
		} else {
			$response['error'] = false;
			$response['message'] = "Cannot complete user registration";
		}
	}
} else{
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);

?>

<form method="post">

    <div>
        <label for="name">Navn:</label><br/>
        <input name="name" type="text" />
    </div>
    <div>
        <label for="email">E-post:</label><br/>
        <input name="email" type="email" />
    </div>
    <div>
        <label for="fieldOfStudy">Studieretning:</label><br/>
        <input name="fieldOfStudy" type="text" />
    </div>
    <div>
        <label for="year">Kull:</label><br/>
        <input name="year" type="number" />
    </div>
    <div>
        <label for="password">Passord:</label><br/>
        <input name="password" type="password" />
    </div>
    <input name="submit" type="submit" />

</form>