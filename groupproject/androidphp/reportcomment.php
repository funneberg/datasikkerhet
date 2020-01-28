<?php

include "connection.php";

$response = array();
if(isset($_POST['messageID'])){
    $messageID = $_POST['messageID'];
    $reported = true;
	$stmt = $conn->prepare("UPDATE kommentar SET rapportert = ? WHERE kommentarID = ?");
	$stmt->bind_param("ii", $reported, $messageID);
    $stmt->execute();
    $stmt->fetch();
    $response['error'] = false;
    $response['message'] = "Rapportert";
} else {
	$response['error'] = true;
	$response['message'] = $stmt->mysqli_error();
}
echo json_encode($response);

?>