<?php

include "connection.php";

$response = array();
if(isset($_POST['messageID'])){
    $messageID = $_POST['messageID'];
    $reported = true;
    $stmt = $conn->prepare("UPDATE henvendelse SET rapportert = ? WHERE id = ?");

	$stmt->bind_param("ii", $reported, $messageID);
    $stmt->execute();
    $stmt->fetch();

    print
    $response['error'] = false;
    $response['message'] = "Rapportert";
} else {
	$response['error'] = true;
	$response['message'] = "Det oppstod en feil";
}
echo json_encode($response);

?>

<form method="post">

<input type="number" name="messageID">

<input type="submit"/>

</form>