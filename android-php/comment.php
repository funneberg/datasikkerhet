<?php

include "connection.php";

$response = array();
if(isset($_POST['emailFrom']) && isset($_POST['emailTo']) && isset($_POST['comment'])){
    $emailFrom = $_POST['emailFrom'];
    $emailTo = $_POST['emailTo'];
	$comment = $_POST['comment'];
	$stmt = $conn->prepare("INSERT INTO melding (avsenderEpost, mottakerEpost, melding) VALUES (?, ?, ?)");
	$stmt->bind_param("sss",$emailFrom, $emailTo, $comment);
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

<form method="post">

    <div>
        <label for="emailTo">Til:</label><br/>
        <input name="emailTo" type="email" />
    </div>
    
    <div>
        <label for="emailFrom">Fra:</label><br/>
        <input name="emailFrom" type="email" />
    </div>
    
    <div>
        <label for="comment">Melding:</label><br/>
        <input name="comment" type="textarea" />
    </div>
    <input type="submit" />

</form>