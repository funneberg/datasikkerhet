<?php

include "connection.php";

$response = array();
if(isset($_POST['emailFrom']) && isset($_POST['emailTo']) && isset($_POST['coursecode']) && isset($_POST['comment'])){
    $emailFrom = $_POST['emailFrom'];
    $emailTo = $_POST['emailTo'];
    $coursecode = $_POST['coursecode'];
	$comment = $_POST['comment'];
	$stmt = $conn->prepare("INSERT INTO henvendelse (avsenderEpost, mottakerEpost, emnekode, henvendelse, rapportert) VALUES (?, ?, ?, ?, false)");
	$stmt->bind_param("ssss",$emailFrom, $emailTo, $coursecode, $comment);
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

<!--
<form method="post">

    <div>
        <label for="emailTo">Til:</label><br/>
        <input name="emailTo" type="email" value="roger.nilsen@hiof.no" />
    </div>
    
    <div>
        <label for="emailFrom">Fra:</label><br/>
        <input name="emailFrom" type="email" value="jan@jan.no" />
    </div>
    
    <div>
        <label for="coursecode">Melding:</label><br/>
        <input name="coursecode" type="text" value="ITF10619" />
    </div>

    <div>
        <label for="comment">Melding:</label><br/>
        <input name="comment" type="text" value="Halla!" />
    </div>
    <input type="submit" />

</form>
-->