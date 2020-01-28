<?php

    include "connection.php";

    session_start();

    global $con;

    if (isset($_GET['emnekode'])) {

        $emnekode = $_GET['emnekode'];

        $sql = "SELECT * FROM emner WHERE emnekode = '$emnekode'";

        $result = mysqli_query($con, $sql);

        $course = mysqli_fetch_array($result);

        echo "<h1>".$course['emnekode']." ".$course['emnenavn']."</h1>";

        $sql2 = "SELECT id, henvendelse, svar, navn FROM henvendelse, foreleser WHERE emnekode = '".$course['emnekode']."' AND mottaker = epost ORDER BY id DESC";

        $result2 = mysqli_query($con, $sql2);

        if (!$result2) {
            echo mysqli_error($con);
        }

        while($inquiry = mysqli_fetch_array($result2)) {
            echo "<div style='position:relative;padding:10px;margin:15px;border: 2px solid black;width:500px;'>
                <p>".$inquiry['henvendelse']."</p>
                <form method='post'>
                <input value='Rapporter' name='report' value='".$inquiry['id']."' type='submit' style='position:absolute;right:0;top:0;'/>
                </form>
                <form method='post'>
                <textarea name='message' cols='66' rows='7' type='text' >
                </textarea><button name='sendInquiry' value='".$inquiry['id']."'>Send</button>
                </form>";
            
            if ($inquiry['svar'] != null) {
                echo "<div><p>Svar fra ".$inquiry['navn'].":</p></div>";
            }

            $comments = getComments($inquiry['id']);

            if (sizeof($comments) > 0) {
                echo "<p>Kommentarer (".sizeof($comments)."):</p>";
                foreach($comments as $comment) {
                    echo "<div style='position:relative;padding:10px;margin:15px;border: 2px solid black;'>
                    <form method='post'>
                    <input value='Rapporter' name='report' value='".$comment['id']."' type='submit' style='position:absolute;right:0;top:0;'/>
                    </form>
                    <p>".$comment['kommentar']."</p>
                    </div>";
                }
            }

            echo "</div>";
        }
    }

    function getComments($inquiryCode) {

        global $con;
        
        $sql = "SELECT * FROM kommentar WHERE kommentarTil = $inquiryCode ORDER BY id DESC";

        $result = mysqli_query($con, $sql);

        $comments = array();

        while($comment = mysqli_fetch_array($result)) {
            $comments[] = $comment;
        }

        return $comments;

    }

    function sendInquiry($message, $lecturer, $coursecode) {

        global $con;

        if (isset($_SESSION["username"])) {
            $email = $_SESSION["username"];

            $sql = "INSERT INTO henvendelse (avsender, mottaker, emnekode, henvendelse) VALUES ('$email', '$lecturer', '$coursecode', '$message')";
        }
        else {
            $sql = "INSERT INTO henvendelse (mottaker, emnekode, henvendelse) VALUES ('$lecturer', '$coursecode', '$message')";
        }

        $result = mysqli_query($con, $sql);

        header("Refresh: 0");

    }

    function sendComment($message, $replyTo) {

        global $con;

        if (isset($_SESSION["username"])) {
            $email = $_SESSION["username"];

            $sql = "INSERT INTO kommentar (avsender, kommentar_til, kommentar) VALUES ('$email', '$replyTo', '$message')";
        }
        else {
            $sql = "INSERT INTO kommentar (kommentarTil, kommentar) VALUES ('$replyTo', '$message')";
        }

        echo "SQL: ".$sql;

        $result = mysqli_query($con, $sql);

        header('Refresh: 0');

    }

    if (isset($_POST["inquiry"]) && isset($_POST["sendInquiry"])) {
        $message = nl2br($_POST["inquiry"]);
        $replyTo = $_POST["sendInquiry"];

        echo $message." ".$replyTo;
        
        sendInquiry($message, $lecturer, $coursecode);
    }

    if (isset($_POST["comment"]) && isset($_POST["sendComment"])) {
        $message = nl2br($_POST["comment"]);
        $replyTo = $_POST["sendComment"];

        echo $message." ".$replyTo;
        
        sendComment($message, $replyTo);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <?php load() ?>
    </div>
</body>
</html>