<?php

include "connection.php";

$response = array();
if(isset($_POST['']){
    $emailFrom = $_POST['emailFrom'];
    $parentCommentID = $_POST['parentCommentID'];
	$comment = $_POST['comment'];
	$stmt = $conn->prepare("INSERT INTO kommentar (avsender, kommentarTil, kommentar, rapportert) VALUES (?, ?, ?)");
	$stmt->bind_param("ssss",$emailFrom, $parentCommentID, $comment);
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