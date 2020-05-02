<?php

/**
 * En modell for Admin.
 */
class Admin extends Model {

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, array $response = []) {
        parent::__construct($mysqli, $logger);
        $lecturers = $this->loadUnauthorizedLecturers();
        $this->response = array_replace($response, $this->lecturers)
    }

    /**
     * Henter forelesere som ikke er godkjente fra databasen.
     */
    private function loadUnauthorizedLecturers(): array {
        $stmt = $this->mysqli->prepare("SELECT * FROM foreleser WHERE godkjent = 0");
        $stmt->execute();
        $result = $stmt->get_result();
        $lecturers = [];
        while($lecturer = $result->fetch_assoc()) {
            $lecturers[] = $lecturer;
        }
        return $lecturers;
    }

    /**
     * Godkjenner en foreleser.
     */
    public function authorizeLecturer(string $email): Admin {

        $email = trim($email);

        $stmt = $this->mysqli->prepare("UPDATE foreleser SET godkjent = 1 WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $response['error'] = false;
            $response['message'] = "Foreleser godkjent";
            $this->logger->info('Admin godkjente en foreleser.', ['admin' => $_SESSION['user'], 'foreleser' => $email]);
        }
        else{
            $response['error'] = true;
            $response['message'] = "Noe gikk galt";
            $this->logger->warning('Admin prøvde å godkjenne en foreleser som ikke eksisterer eller allerede er godkjent', ['brukernavn' => $email]);
        }
        return new Admin($this->mysqli, $this->logger, $response);
    }

}

?>