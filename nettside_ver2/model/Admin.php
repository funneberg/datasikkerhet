<?php

/**
 * En modell for Admin.
 */
class Admin extends Model {

    private $lecturers;

    public function __construct(MySQLi $mysqli) {
        parent::__construct($mysqli);
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
        $stmt = $this->mysqli->prepare("UPDATE foreleser SET godkjent = 1 WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        return new Admin($this->mysqli);
    }

    /**
     * Henter arrayet med forelesere som ikke er godkjent.
     */
    public function getUnauthorizedLecturers(): array {
        return $this->lecturers;
    }

}

?>