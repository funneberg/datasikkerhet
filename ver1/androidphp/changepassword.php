<?php

include "connection.php";

$response = array();
if(isset($_POST['email']) && isset($_POST['oldPassword']) && isset($_POST['newPassword1']) && isset($_POST['newPassword2'])){
    $email = $_POST['email'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    $sql = $conn->prepare("SELECT passord FROM student WHERE epost = ?");
    $sql->bind_param("s",$email);
	$sql->execute();
    $sql->bind_result($db_password);
    $sql->fetch();
    $sql->close();

    if($oldPassword == $db_password){
        if ($newPassword1 == $newPassword2) {
            if($stmt = $conn->prepare("UPDATE student SET passord = ? WHERE epost = ?")) {
                $stmt->bind_param("ss", $newPassword1, $email);
                $stmt->execute();
                $stmt->store_result();
                $response['error'] = false;
                $response['message'] = "Passordet er endret";
            }
            else {
                $error = $conn->errno." ".$conn->error;
                echo $error;
            }
        }
        else {
            $response['error'] = false;
            $response['message'] = "Nytt passord var ikke riktig";
        }
    }
    else {
        $response['error'] = false;
		$response['message'] = "Feil passord";
    }
} else{
	$response['error'] = true;
    $response['message'] = "Alle feltene må fylles ut";
}
print(json_encode($response));

?>