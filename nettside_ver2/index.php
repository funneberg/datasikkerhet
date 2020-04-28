<?php

include("model/Model.php");
include("view/View.php");
include("controller/Controller.php");

require('/../../../home/datasikkerhet/vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\LogglyHandler;
use Monolog\Formatter\LogglyFormatter;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;

use Monolog\Handler\GelfHandler;
use Gelf\Message;
use Monolog\Formatter\GelfMessageFormatter;

$logger = new Monolog\Logger('sikkerhet');

// Fillogging
$logger->pushHandler(new StreamHandler(__DIR__.'/test_log/log.txt', Logger::DEBUG));

// GELF
$transport = new Gelf\Transport\UdpTransport("127.0.0.1", 12201 /*, Gelf\Transport\UdpTransport::CHUNK_SIZE_LAN*/);
$publisher = new Gelf\Publisher($transport);
$handler = new GelfHandler($publisher,Logger::DEBUG);

$logger->pushHandler($handler);

/*
$logger->pushProcessor(function ($record) {
    $record['extra']['user'] = 'admin';

    return $record;
});
*/

// Database
$servername = "localhost";
$username = "root";
$password = "skosaalen!";
$dbname = "datasikkerhet";

// Oppretter forbindelse med databasen.
$mysqli = new MySQLi($servername,$username,$password,$dbname);

// Starter en sesjon.
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = "Gjest-".uniqid();
    $_SESSION['guest'] = true;
}

$logger->pushProcessor(function ($record) {
    $record['extra']['user'] = $_SESSION['user'];

    return $record;
});

$page = $_GET['page'] ?? '';

// En "router", som sender brukeren til riktig side:

// Hvis det ikke er spesifisert noen side, og man er logget inn som student eller foreleser,
// blir man sendt til hjemmesiden.
if ($page == '' && (isset($_SESSION['student']) || isset($_SESSION['lecturer']))) {
    include("model/Home.php");
    include("view/HomeView.php");

    $model = new Home($mysqli, $logger);
    $view = new HomeView();
}

// Hvis det ikke er spesifisert noen side, og man er logget inn som administrator,
// blir man sendt til administratorsiden.
else if ($page == '' && isset($_SESSION['admin'])) {
    include("model/Admin.php");
    include("view/AdminView.php");
    include("controller/AdminController.php");

    $model = new Admin($mysqli, $logger);
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

    $model = new Login($mysqli, $logger);
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

    $model = new Register($mysqli, $logger);
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

    $model = new CourseCreator($mysqli, $logger, $_SESSION['user']);
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

    $model = new CourseList($mysqli, $logger);
    $view = new CourseListView();
    $controller = new CourseListController();

    if (isset($_GET['search'])) {
        $model = $controller->search($model);
    }
}

// Hvis man prøver å gå til en side for et emne, og er logget inn, eller har PIN-kode,
// blir man sendt til emnesiden.
else if ($page == 'course' && isset($_GET['code']) && (isset($_SESSION['loggedIn']) || isset($_SESSION['access'][$_GET['code']]))) {
    include("model/Course.php");
    include("view/CourseView.php");
    include("controller/CourseController.php");

    $model = new Course($mysqli, $logger, $_GET['code']);
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

    $model = new Course($mysqli, $logger, $_GET['code']);
    $view = new PinCodeView();
}
else if ($page == 'settings') {
    include("model/Settings.php");
    include("view/SettingsView.php");
    include("controller/SettingsController.php");

    $model = new Settings($mysqli, $logger);
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

    $model = new App($mysqli, $logger);
    $view = new AppView();
    $controller = new AppController();

    if (isset($_POST['download'])) {
        $model = $controller->download($model);
    }
}

// Ødelegger sesjonen hvis man logger ut.
else if ($page == 'logout') {

    $logger->info('Bruker logget ut.', ['brukernavn' => $_SESSION['user']]);

    session_destroy();
    header("location: index.php");
}

// Får feilmelding hvis man prøver å gå til en side som ikke eksisterer.
else {

    $logger->info('Bruker prøvde å gå til en side som ikke eksisterer.', ['side' => $page]);

    http_response_code(404);
    die;
}

// Skriver ut siden.
$view->output($model);

?>