<?php

/**
 * En modell for å lage emner.
 */
class CourseCreator extends Model {

    private $lecturerEmail;
    private $courses;

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, string $email) {
        parent::__construct($mysqli, $logger);
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

        $courseName = trim($course['coursename']);
        $courseCode = trim($course['coursecode']);
        $email = $_SESSION['user'];
        $pin = password_hash(stripslashes(trim($course['pin'])), PASSWORD_DEFAULT);

        //Sjekker at emnenavn og emnekode bare inneholder bokstaver og tall, og at pinkoden bare inneholder tall. 
        if (preg_match("/^[a-zA-Z0-9 ]*$/" , $courseName) && preg_match("/^[a-zA-Z0-9 ]*$/" , $courseCode) && preg_match("/^[0-9 ]*$/" , $coursePin) )  {

            if ($this->isAuthorized()) {
                $stmt = $this->mysqli->prepare("INSERT INTO emner (emnekode, emnenavn, foreleser, PIN) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $coursecode, $coursename, $email, $pin);
                $stmt->execute();

                $this->logger->info('Bruker opprettet et nytt emne.', ['emnekode' => $coursecode, 'brukernavn' => $email]);
            }

        }
        else{
            $this->logger->info('Bruker prøvde å opprette et nytt emne. Opprettelse mislykket.', ['brukernavn' => $email]);
        }

        return new CourseCreator($this->mysqli, $this->logger, $this->lecturerEmail);
    }

    /**
     * Sjekker om foreleseren som er logget inn er autorisert.
     */
    public function isAuthorized(): bool {
        $stmt = $this->mysqli->prepare("SELECT * FROM foreleser WHERE godkjent = 1 AND epost = ?");
        $stmt->bind_param("s", $_SESSION['user']);
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