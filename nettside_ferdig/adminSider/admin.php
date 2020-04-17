<?php

    include "../connection.php";
    //include "../../test/redirect.php";

    session_start();

    ////////////////////////////////////////////////////////////////////
    // Redirecter brukeren hvis man ikke er logget inn som admin.
    ////////////////////////////////////////////////////////////////////

    if (isset($_SESSION['foreleser'])) {
        header("Location: ../foreleserSider/foreleserHome.php");
        exit();
    }
    if (isset($_SESSION['student'])) {
        header("Location: ../studentSider/studentHome.php");
        exit();
    }
    if (!isset($_SESSION['admin'])) {
        header("Location: ../index.php");
        exit();
    }

    /////////////////////////////////////////////////////////////////////

    if (isset($_SESSION['admin'])) {

        if (isset($_POST['godkjenn'])) {
            $lecturer = $_POST['godkjenn'];

            $sql2 = "UPDATE foreleser SET godkjent = 1 WHERE epost = '$lecturer'";

            $result2 = mysqli_query($con, $sql2);
        }

        function loadLecturers(){

            global $con;

            $sql = "SELECT * FROM foreleser WHERE godkjent = 0";

            $result = mysqli_query($con, $sql);

            while($row = mysqli_fetch_array($result)) {
                echo "<div style='padding:15px;margin-bottom:10px;border-style:solid;border-radius:5px;border-color:black;width:300px;'>
                    <p>".$row['navn']."</p><p>".$row['epost']."</p>
                    <button name='godkjenn' value='".$row['epost']."'>Godkjenn</button></div>";
            }

        }

        function countLecturers() {

            global $con;

            $sql = "SELECT count(*) AS cntLecturer FROM foreleser WHERE godkjent = 0";

            $result = mysqli_query($con, $sql);

            $row = mysqli_fetch_array($result);

            echo $row['cntLecturer'].($row['cntLecturer'] == 1 ? " håpefull foreleser " : " håpefulle forelesere ")." venter på å bli godkjent:";

        }

    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Document</title>
</head>
<body>
    <p>(Web-designeren vår dro på ferie)</p>
    <nav>
        <a href="../logout.php">Logg ut</a>
    </nav>
    <p>
		<?php echo "Hei ".$_SESSION["username"] ?>
	</p>
    <p>
        <?php countLecturers() ?>
    </p>
    <form method="post">
        <?php loadLecturers() ?>
    </form>
</body>
</html>