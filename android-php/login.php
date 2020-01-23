<?php

include "connection.php";

$response = array();
if(isset($_POST['email']) && isset($_POST['password'])){
	$email = $_POST['email'];
	$post_password = $_POST['password'];
	$stmt = $conn->prepare("SELECT navn, studieretning, kull, passord FROM student WHERE epost = ?");
	$stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($db_name, $db_fieldOfStudy, $db_year, $db_password);
    $stmt->fetch();
	if($post_password == $db_password){
		$response['error'] = false;
		$response['message'] = "Login Successful!";
        $response['name'] = $db_name;
        $response['email'] = $email;
        $response['fieldOfStudy'] = $db_fieldOfStudy;
        $response['year'] = $db_year;
	} else{
		$response['error'] = false;
		$response['message'] = "Invalid Email or Password";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);

?>

<form method="post">

    <div>
        <label for="email">E-post:</label><br/>
        <input name="email" type="email" />
    </div>
    <div>
        <label for="password">Passord:</label><br/>
        <input name="password" type="password" />
    </div>
    <input name="submit" type="submit" />

</form>