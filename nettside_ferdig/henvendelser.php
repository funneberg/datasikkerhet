<?php

    include "connection.php";

    session_start();

    global $con;

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
    <nav>
        <?php if (isset($_SESSION["student"])) { ?>
        <a href="studentSider/sEmner.php">Tilbake</a>
        <?php } else if (isset($_SESSION["foreleser"])) { ?>
            <a href="foreleserSider/addEmner.php">Tilbake</a>
        <?php } else { ?>
            <a href="gjesteSider/emner.php">Tilbake</a>
        <?php } ?>
    </nav>


<?php

    if (isset($_GET['emnekode'])) {

        $coursecode = $_GET['emnekode'];

        $sql = "SELECT * FROM emner WHERE emnekode = '$coursecode'";

        $result = mysqli_query($con, $sql);

        $course = mysqli_fetch_array($result);

        echo "<h1>".$course['emnekode']." ".$course['emnenavn']."</h1>";

        $sql2 = "SELECT id, henvendelse, svar, navn, epost, bilde FROM henvendelse, foreleser WHERE emnekode = '".$course['emnekode']."' AND mottaker = epost ORDER BY id DESC";

        $result2 = mysqli_query($con, $sql2);

        if (!$result2) {
            echo mysqli_error($con);
        }

        $row = mysqli_fetch_array($result2);

        $lecturerName = $row["navn"];
        $lecturerEmail = $row["epost"];
        $lecturerImg = $row['bilde'];

        $svar = $row["svar"];

        echo "<p>".$lecturerName."</p><p>".$lecturerEmail."</p><img width='200' src='bilder/".$lecturerImg."'/>";

        if (isset($_POST["inquiry"]) && isset($_POST["sendInquiry"])) {
            $message = nl2br($_POST["inquiry"]);
            
            sendInquiry($message, $lecturerEmail, $coursecode);
        }
    
        if (isset($_POST["comment"]) && isset($_POST["sendComment"])) {

            $message = nl2br($_POST["comment"]);
            $replyTo = $_POST["sendComment"];

            if (isset($_SESSION['foreleser'])) {
                if ($svar == null) {
                    $sql_query1 = "UPDATE henvendelse SET svar = '$message' WHERE id = $replyTo";

                    $result3 = mysqli_query($con, $sql_query1);

                    if (!$result3) {
                        echo mysqli_error($con);
                    }
                }
            }
            else {
                sendComment($message, $replyTo);
            }
        }

    }

    if (isset($_POST['reportInquiry'])) {
        $report = $_POST['reportInquiry'];
        $sql_query = "UPDATE henvendelse SET rapportert = 1 WHERE id = $report";

        mysqli_query($con, $sql_query);

        if (!$result) {
            echo mysqli_error($con);
        }
    }

    if (isset($_POST['reportComment'])) {
        $report = $_POST['reportComment'];
        $sql_query = "UPDATE kommentar SET rapportert = 1 WHERE id = $report";

        $result = mysqli_query($con, $sql_query);

        if (!$result) {
            echo mysqli_error($con);
        }
    }

    function loadInquiries($result) {
        while($inquiry = mysqli_fetch_array($result)) {
            echo "<div style='position:relative;padding:10px;margin:15px;border: 2px solid black;width:500px;'>
                <p>".$inquiry['henvendelse']."</p>
                <form method='post'>
                <button name='reportInquiry' value='".$inquiry['id']."' type='submit' style='position:absolute;right:0;top:0;'>Rapporter</button>
                </form>
                <form method='post'>
                <textarea name='comment' cols='66' rows='7' type='text' >
                </textarea><button name='sendComment' type='submit' value='".$inquiry['id']."'>Send</button>
                </form>";
            
            if ($inquiry['svar'] != null) {
                echo "<div><p>Svar fra ".$inquiry['navn'].": </p><p>".$inquiry['svar']."</div>";
            }

            $comments = getComments($inquiry['id']);

            if (sizeof($comments) > 0) {
                echo "<p>Kommentarer (".sizeof($comments)."):</p>";
                foreach($comments as $comment) {
                    echo "<div style='position:relative;padding:10px;margin:15px;border: 2px solid black;'>
                    <form method='post'>
                    <button name='reportComment' value='".$comment['id']."' type='submit' style='position:absolute;right:0;top:0;'>Rapporter</button>
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
        
        $sql = "SELECT * FROM kommentar WHERE kommentar_til = $inquiryCode ORDER BY id DESC";

        $result = mysqli_query($con, $sql);

        if (!$result) {
            echo mysqli_error($con);
        }

        $comments = array();

        while($comment = mysqli_fetch_array($result)) {
            $comments[] = $comment;
        }

        return $comments;

    }

    function sendInquiry($message, $lecturerEmail, $coursecode) {

        global $con;

        if (isset($_SESSION["username"])) {
            $email = $_SESSION["username"];

            $sql = "INSERT INTO henvendelse (avsender, mottaker, emnekode, henvendelse) VALUES ('$email', '$lecturerEmail', '$coursecode', '$message')";
        }
        else {
            $sql = "INSERT INTO henvendelse (mottaker, emnekode, henvendelse) VALUES ('$lecturerEmail', '$coursecode', '$message')";
        }

        $result = mysqli_query($con, $sql);

        if (!$result) {
            echo mysqli_error($con);
        }

        //header("Refresh: 0");

    }

    function sendComment($message, $replyTo) {

        global $con;

        if (isset($_SESSION["username"])) {
            $email = $_SESSION["username"];

            $sql = "INSERT INTO kommentar (avsender, kommentar_til, kommentar) VALUES ('$email', '$replyTo', '$message')";
        }
        else {
            $sql = "INSERT INTO kommentar (kommentar_til, kommentar) VALUES ('$replyTo', '$message')";
        }

        $result = mysqli_query($con, $sql);

        if (!$result) {
            echo mysqli_error($con);
        }

        //header("Refresh: 0");

    }

?>


    <div>
        <?php if (!isset($_SESSION["foreleser"])) { ?>
            <form method="post">
                <textarea cols="66" rows="7" name="inquiry"></textarea>
                <input name="sendInquiry" type="submit" />
            </form>
        <?php } ?>
    </div>
    <div>
        <?php loadInquiries($result2) ?>
    </div>
</body>
</html>