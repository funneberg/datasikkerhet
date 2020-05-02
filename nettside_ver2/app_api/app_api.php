<?php

include("../model/Model.php");
include("../view/View.php");
include("../controller/Controller.php");

include("../logger.php");

// Database
$servername = "localhost";
$username = "root";
$password = "skosaalen!";
$dbname = "datasikkerhet";

// Oppretter forbindelse med databasen.
$mysqli = new MySQLi($servername,$username,$password,$dbname);

$page = $_GET['page'] ?? '';

if ($page == 'login') {
    include("../model/Login.php");
    include("../controller/LoginController.php");

    $model = new Login($mysqli, $logger);
    $controller = new LoginController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = $controller->signInStudent($model);
    }
}
else if ($page == 'register') {
    include("../model/Register.php");
    include("../controller/RegisterController.php");

    $model = new Register($mysqli, $logger);
    $controller = new RegisterController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = $controller->signUpStudent($model);
    }
}
else if ($page == 'courses') {
    include("../model/CourseList.php");
    include("../controller/CourseListController.php");

    $search = $_GET['search'] ?? '';

    $model = new CourseList($mysqli, $logger, $search);
    $controller = new CourseListController();
}
else if ($page == 'course' && isset($_GET['code'])) {
    include("../model/Course.php");
    include("../controller/CourseController.php");

    $model = new Course($mysqli, $logger, $_GET['code']);
    $controller = new CourseController();

    if (isset($_POST['sendInquiry'])) {
        $model = $controller->submitStudentInquiry($model);
    }
    else if (isset($_POST['reportInquiry'])) {
        $model = $controller->studentReportInquiry($model);
    }
    else if (isset($_POST['sendComment'])) {
        $model = $controller->submitStudentComment($model);
    }
    else if (isset($_POST['reportComment'])) {
        $model = $controller->studentReportComment($model);
    }
}
else if ($page == 'settings') {
    include("../model/Settings.php");
    include("../controller/SettingsController.php");

    $model = new Settings($mysqli, $logger);
    $controller = new SettingsController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = $controller->changeStudentPassword($model);
    }
}
else {
    http_response_code(404);
    die;
}

print(json_encode($model->getResponse()));

?>