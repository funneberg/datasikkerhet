<?php

/**
 * En modell for å lage emner.
 */
class CourseCreator extends Model {

    private $lecturerEmail;
    private $courses;

    public function __construct(MySQLi $mysqli, string $email) {
        parent::__construct($mysqli);
        $this->lecturerEmail = $email;
        $this->courses = $this->loadCourses();
    }

    /**
     * Laster inn emnene til foreleseren som er logget inn.
     */
    private function loadCourses(): array {
        $stmt = $this->mysqli->prepare("SELECT *, navn FROM emner, foreleser WHERE foreleser = ? AND foreleser = epost");
        $stmt->bind_param("s", $this->lecturerEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = [];
        while ($course = $result->fetch_assoc()) {
            $courses[] = $course;
        }
        return $courses;
    }

    /**
     * Lagrer et nytt emne i databasen.
     */
    public function createCourse($course): CourseCreator {

        $coursecode = $course['coursecode'];
        $coursename = $course['coursename'];
        $email = $_SESSION['email'];
        $pin = password_hash($course['pin'], PASSWORD_DEFAULT);

        if ($this->isAuthorized()) {
            $stmt = $this->mysqli->prepare("INSERT INTO emner (emnekode, emnenavn, foreleser, PIN) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $coursecode, $coursename, $email, $pin);
            $stmt->execute();
        }
        return new CourseCreator($this->mysqli, $this->lecturerEmail);
    }

    /**
     * Sjekker om foreleseren som er logget inn er autorisert.
     */
    public function isAuthorized(): bool {
        $stmt = $this->mysqli->prepare("SELECT * FROM foreleser WHERE godkjent = 1 AND epost = ?");
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Returnerer emnene til foreleseren som er logget inn.
     */
    public function getCourses(): array {
        return $this->courses;
    }

}

?>