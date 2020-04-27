<?php

include "connection.php";

$response = array();
if(isset($_POST['emailFrom']) && isset($_POST['parentCommentID']) && isset($_POST['comment'])){
    $emailFrom = $_POST['emailFrom'];
    $parentCommentID = $_POST['parentCommentID'];
	$comment = $_POST['comment'];
	$stmt = $conn->prepare("INSERT INTO kommentar (avsender, kommentar_til, kommentar, rapportert) VALUES (?, ?, ?, 0)");
	$stmt->bind_param("sss",$emailFrom, $parentCommentID, $comment);
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