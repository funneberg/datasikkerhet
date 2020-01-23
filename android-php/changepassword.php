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
                $response['message'] = "Password updated";
            }
            else {
                $error = $conn->errno." ".$conn->error;
                echo $error;
            }
        }
        else {
            $response['error'] = false;
            $response['message'] = "Wrong password";
        }
    }
    else {
        $response['error'] = false;
		$response['message'] = "Wrong password grr";
    }
} else{
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
        <label for="oldPassword">Gammelt passord:</label><br/>
        <input name="oldPassword" type="password" />
    </div>
    
    <div>
        <label for="newPassword1">Nytt passord:</label><br/>
        <input name="newPassword1" type="password" />
    </div>
    
    <div>
        <label for="newPassword2">Nytt passord igjen:</label><br/>
        <input name="newPassword2" type="password" />
    </div>
    <input type="submit" />

</form>