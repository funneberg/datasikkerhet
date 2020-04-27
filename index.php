<?php

include("model/Model.php");
include("view/View.php");
include("controller/Controller.php");

$servername = "localhost";
$username = "root";
$password = "skosaalen!";
$dbname = "datasikkerhet";

// Oppretter forbindelse med databasen.
$mysqli = new MySQLi($servername,$username,$password,$dbname);

// Starter en sesjon.
session_start();

$page = $_GET['page'] ?? '';

// En "router", som sender brukeren til riktig side:

// Hvis det ikke er spesifisert noen side, og man er logget inn som student eller foreleser,
// blir man sendt til hjemmesiden.
if ($page == '' && (isset($_SESSION['student']) || isset($_SESSION['lecturer']))) {
    include("model/Home.php");
    include("view/HomeView.php");

    $model = new Home($mysqli);
    $view = new HomeView();
}

// Hvis det ikke er spesifisert noen side, og man er logget inn som administrator,
// blir man sendt til administratorsiden.
else if ($page == '' && isset($_SESSION['admin'])) {
    include("model/Admin.php");
    include("view/AdminView.php");
    include("controller/AdminController.php");

    $model = new Admin($mysqli);
    $view = new AdminView();
    $controller = new AdminController();

    if (isset($_POST['authorize'])) {
        $model = $controller->authorizeLecturer($model);
    }
}

// Hvis man ikke er logget inn, og det ikke er spesifisert noen side, blir man sendt til login-siden.
else if ($page == '') {
    include("model/Login.php");
    include("view/LoginView.php");
    include("controller/LoginController.php");

    $model = new Login($mysqli);
    $view = new LoginView();
    $controller = new LoginController();

    if (isset($_POST['login'])) {
        $model = $controller->signIn($model);
    }
}
else if ($page == 'register') {
    include("model/Register.php");
    include("view/RegisterView.php");
    include("controller/RegisterController.php");

    $model = new Register($mysqli);
    $view = new RegisterView();
    $controller = new RegisterController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $model = $controller->signUp($model);
    }
}

// Hvis man prøver å gå til siden for emner, og er logget inn som foreleser,
// sendes man til en side hvor man kan opprette nye emner og se sine egne emner.
else if ($page == 'courses' && isset($_SESSION['lecturer'])) {
    include("model/CourseCreator.php");
    include("view/CourseCreatorView.php");
    include("controller/CourseCreatorController.php");

    $model = new CourseCreator($mysqli, $_SESSION['email']);
    $view = new CourseCreatorView();
    $controller = new CourseCreatorController();

    if (isset($_POST['submitCourse'])) {
        $model = $controller->createCourse($model);
    }
}
else if ($page == 'courses') {
    include("model/CourseList.php");
    include("view/CourseListView.php");
    include("controller/CourseListController.php");

    $model = new CourseList($mysqli);
    $view = new CourseListView();
    $controller = new CourseListController();

    if (isset($_POST['search'])) {
        $model = $controller->search($model);
    }
}

// Hvis man prøver å gå til en side for et emne, og er logget inn, eller har PIN-kode,
// blir man sendt til emnesiden.
else if ($page == 'course' && isset($_GET['code']) && (isset($_SESSION['loggedIn']) || isset($_SESSION['access'][$_GET['code']]))) {
    include("model/Course.php");
    include("view/CourseView.php");
    include("controller/CourseController.php");

    $model = new Course($mysqli, $_GET['code']);
    $view = new CourseView();
    $controller = new CourseController();

    if (isset($_POST['sendInquiry'])) {
        $model = $controller->submitInquiry($model);
    }
    else if (isset($_POST['reportInquiry'])) {
        $model = $controller->reportInquiry($model);
    }
    else if (isset($_POST['sendComment'])) {
        $model = $controller->submitComment($model);
    }
    else if (isset($_POST['reportComment'])) {
        $model = $controller->reportComment($model);
    }
}

// Hvis man ikke er logget inn, og ikke har oppgitt riktig PIN-kode, blir man sendt til en side
// hvor man må skrive inn en PIN-kode.
else if ($page == 'course' && isset($_GET['code'])) {
    include("model/Course.php");
    include("view/PinCodeView.php");
    include("controller/PinCodeController.php");

    $model = new Course($mysqli, $_GET['code']);
    $view = new PinCodeView();
}
else if ($page == 'settings') {
    include("model/Settings.php");
    include("view/SettingsView.php");
    include("controller/SettingsController.php");

    $model = new Settings($mysqli);
    $view = new SettingsView();
    $controller = new SettingsController();

    if (isset($_POST['changePassword'])) {
        $model = $controller->changePassword($model);
    }
}
else if ($page == 'app') {
    include("model/App.php");
    include("view/AppView.php");
    include("controller/AppController.php");

    $model = new App($mysqli);
    $view = new AppView();
    $controller = new AppController();

    if (isset($_POST['download'])) {
        $model = $controller->download($model);
    }
}

// Ødelegger sesjonen hvis man logger ut.
else if ($page == 'logout') {
    session_destroy();
    header("location: index.php");
}

// Får feilmelding hvis man prøver å gå til en side som ikke eksisterer.
else {
    http_response_code(404);
    echo "Siden ble ikke funnet.";
    die;
}

// Skriver ut siden.
$view->output($model);

?>