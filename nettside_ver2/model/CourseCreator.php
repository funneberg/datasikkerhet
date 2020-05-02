<?php

/**
 * En modell for å lage emner.
 */
class CourseCreator extends Model {

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, string $lecturer, array $response = []) {
        parent::__construct($mysqli, $logger, $response);
        $this->response = $this->loadCourses($lecturer);
    }

    /**
     * Laster inn emnene til foreleseren som er logget inn.
     */
    private function loadCourses(string $lecturer): array {
        $stmt = $this->mysqli->prepare("SELECT *, navn FROM emner, foreleser WHERE foreleser = ? AND foreleser = epost");
        $stmt->bind_param("s", $lecturer);
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
        $email = trim($course['user']);

        //Sjekker at emnenavn og emnekode bare inneholder bokstaver og tall, og at pinkoden bare inneholder tall. 
        if (preg_match("/^[a-zA-Z0-9 ]*$/" , $courseName) && preg_match("/^[A-Z]+(|-[A-Z]+)[0-9]+$/", $courseCode) && preg_match("/^[0-9]*$/" , $coursePin) && strlen($coursePin) == 4 && filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $pin = password_hash($course['pin']), PASSWORD_DEFAULT);

            if ($this->isAuthorized($email)) {
                $stmt = $this->mysqli->prepare("INSERT INTO emner (emnekode, emnenavn, foreleser, PIN) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $coursecode, $coursename, $email, $pin);
                $stmt->execute();

                $response['error'] = false;
                $response['message'] = "Nytt emne opprettet";
                $this->logger->info('Foreleser opprettet et nytt emne.', ['emnekode' => $coursecode, 'brukernavn' => $email]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Ikke godkjent";
                $this->logger->info('Foreleser som ikke er godkjent prøvde å opprette et nytt emne. Opprettelse mislykket.', ['brukernavn' => $email]);
            }
        }
        else{
            $response['error'] = true;
            $response['message'] = "Noe gikk galt";
            $this->logger->info('Foreleser prøvde å opprette et nytt emne. Opprettelse mislykket.', ['brukernavn' => $email]);
        }

        return new CourseCreator($this->mysqli, $this->logger, $this->lecturerEmail);
    }

    /**
     * Sjekker om foreleseren som er logget inn er autorisert.
     */
    public function isAuthorized($lecturer): bool {

        $lecturer = stripslashes(trim(htmlspecialchars($lecturer)));

        if (filter_var($lecturer, FILTER_VALIDATE_EMAIL)) {

            $stmt = $this->mysqli->prepare("SELECT * FROM foreleser WHERE godkjent = 1 AND epost = ?");
            $stmt->bind_param("s", $lecturer);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true;
            }
        }
        return false;
    }

}

?>