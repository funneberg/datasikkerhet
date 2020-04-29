<?php

/**
 * En modell for Admin.
 */
class Admin extends Model {

    private $lecturers;

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger) {
        parent::__construct($mysqli, $logger);
        $this->lecturers = $this->loadUnauthorizedLecturers();
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

        $this->logger->info('Admin godkjente en foreleser.', ['admin' => $_SESSION['user'], 'foreleser' => $email]);
        }
        else{
            $this->logger->warning('Admin prøvde å godkjenne en foreleser som ikke eksisterer eller allerede er godkjent', ['brukernavn' => $email]);
        }
        return new Admin($this->mysqli, $this->logger);
    }

    /**
     * Henter arrayet med forelesere som ikke er godkjent.
     */
    public function getUnauthorizedLecturers(): array {
        return $this->lecturers;
    }

}

?>