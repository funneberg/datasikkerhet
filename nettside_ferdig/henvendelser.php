<?php

    include "connection.php";

    session_start();

    if (isset($_POST['reportInquiry'])) {
        $report = $_POST['reportInquiry'];
        $sql_query = "UPDATE henvendelse SET rapportert = 1 WHERE id = $report";

        $result = mysqli_query($con, $sql_query);
    }

    if (isset($_POST['reportComment'])) {
        $report = $_POST['reportComment'];
        $sql_query = "UPDATE kommentar SET rapportert = 1 WHERE id = $report";

        $result = mysqli_query($con, $sql_query);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/comments.css">
</head>
<body>

    <?php
    
        if (isset($_GET['coursecode'])) {

            $coursecode = $_GET['coursecode'];

            $sql_course = "SELECT emnenavn, navn, epost, bilde FROM emner, foreleser WHERE foreleser = epost AND emnekode = '$coursecode'";

            $course = mysqli_fetch_array(mysqli_query($con, $sql_course));

            if (isset($_POST['sendInquiry']) && isset($_POST['inquiry'])) {
                $lecturerEmail = $course['epost'];
                $message = $_POST['inquiry'];
                if (isset($_SESSION['username'])) {
                    $email = $_SESSION['username'];
                    $sql = "INSERT INTO henvendelse (avsender, mottaker, emnekode, henvendelse) VALUES ('$email', '$lecturerEmail', '$coursecode', '$message')";
                }
                else {
                    $sql = "INSERT INTO henvendelse (mottaker, emnekode, henvendelse) VALUES ('$lecturerEmail', '$coursecode', '$message')";
                }
        
                $result = mysqli_query($con, $sql);
            }
        
            if (isset($_POST['sendComment']) && isset($_POST['comment'])) {
                $replyTo = $_POST['sendComment'];
                $message = $_POST['comment'];
                if (isset($_SESSION['username'])) {
                    $email = $_SESSION['username'];
                    $lecturerEmail = $course['epost'];
                    if (isset($_SESSION['foreleser']) && $_SESSION['foreleser']) {
                        $sql = "UPDATE henvendelse SET svar = '$message' WHERE id = '$replyTo'";
                    }
                    else {
                        $sql = "INSERT INTO kommentar (avsender, kommentar_til, kommentar) VALUES ('$email', '$replyTo', '$message')";
                    }
                }
                else {
                    $sql = "INSERT INTO kommentar (kommentar_til, kommentar) VALUES ('$replyTo', '$message')";
                }

                $result = mysqli_query($con, $sql);
            }
        
    ?>

    <nav>
        <?php if (isset($_SESSION['student'])): ?>
            <a href="../nettside_ferdig/studentSider/studentHome.php">Tilbake</a>
        <?php elseif (isset($_SESSION['foreleser'])): ?>
            <a href="../nettside_ferdig/foreleserSider/foreleserHome.php">Tilbake</a>
        <?php else: ?>
            <a href="../nettside_ferdig/index.php">Tilbake</a>
        <?php endif; ?>
    </nav>

    <h1><?php echo $coursecode." ".$course['emnenavn']; ?></h1>
    <p><?php echo $course['navn']; ?></p>
    <p><?php echo $course['epost']; ?></p>
    <img src=<?php echo "bilder/".$course['bilde']; ?> width="100" />

    <form method="post">
        <textarea name="inquiry" cols="66" rows="8"></textarea>
        <button name="sendInquiry">Send</button>
    </form>
    
    <?php

        $sql_inquiry = "SELECT * FROM henvendelse WHERE emnekode = '$coursecode' ORDER BY id DESC";

        $inquiries = mysqli_query($con, $sql_inquiry);

        while($inquiry = mysqli_fetch_array($inquiries)) {

    ?>

        <div class="inquiry" id=<?php echo "inquiry".$inquiry['id'] ?>>
        
            <p><?php echo $inquiry['emnekode']." ".$inquiry['henvendelse']; ?></p>

            <?php

                $showReportInquiry = true;

                if (isset($_SESSION['username'])):

                    $email = $_SESSION['username'];

                    if ($inquiry['avsender'] == $email):

                        $showReportInquiry = false;

                    endif;

                endif;

                if ($showReportInquiry):
            ?>
                <form method="post">
                    <button name="reportInquiry" value=<?php echo $inquiry['id'] ?>>Rapporter</button>
                </form>
            <?php
                endif;
            ?>
            <form method="post">
                <textarea name="comment" cols="66" rows="8"></textarea>
                <button name="sendComment" value=<?php echo $inquiry['id'] ?>>Send</button>
            </form>

            <?php

                $sql_comment = "SELECT * FROM kommentar WHERE kommentar_til = ".$inquiry['id']." ORDER BY id DESC";

                $comments = mysqli_query($con, $sql_comment);

                $sql_numComments = "SELECT count(*) FROM kommentar WHERE kommentar_til = ".$inquiry['id'];
                $numComments = mysqli_fetch_array(mysqli_query($con, $sql_numComments))[0];

                if ($inquiry['svar'] != null) {

                    $answer = $inquiry['svar'];
                    $name = $course['navn'];

            ?>

            <div class="lecturerAnswer" id=<?php echo "answer".$inquiry['id']; ?>>
            
                <p>Svar fra <?php echo $name; ?>:</p>
                <p><?php echo $answer; ?></p>

            </div>

            <?php } ?>

            <p>Kommentarer (<?php echo $numComments; ?>):</p>

            <?php

                while($comment = mysqli_fetch_array($comments)) {
        
            ?>
        
                <!-- inside the while loop -->
                <div class="comment" id=<?php echo "comment".$comment['id']; ?>>
                
                    <p><?php echo $comment['kommentar'] ?></p>
                    <?php

                        $showReportComment = true;

                        if (isset($_SESSION['username'])):

                            $email = $_SESSION['username'];

                            if ($comment['avsender'] == $email) {
                                $showReportComment = false;
                            }

                        endif;

                        if ($showReportComment):
                    ?>
                        <form method="post">
                            <button name="reportComment" value=<?php echo $comment['id'] ?>>Rapporter</button>
                        </form>
                    <?php endif; ?>

                </div>

            <?php } ?>

        </div>

    <?php 
    
            }
        }
    
    ?>

</body>
</html>