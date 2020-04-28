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

        $courseName = trim($course['coursename']);
        $courseCode = trim($course['coursecode']);
        $coursePin = trim($course['pin']);

        //Sjekker at emnenavn bare inneholder bokstaver, emnekode følger et bestemt møster av siffer og bokstaver, og at PIN koden bare er 4 siffer.
        if (preg_match("/^[a-zA-Z \æ\ø\å\Æ\Ø\Å ]*$/" , $courseName) && preg_match("/^[A-Z]+(|-[A-Z]+)[0-9]+$/" , $courseCode) && strlen($courseCode) < 10 && preg_match("/^[0-9 ]*$/" , $coursePin) 
        && strlen($coursePin) == 4)  {

            if ($this->isAuthorized()) {

                $stmt = $this->mysqli->prepare("INSERT INTO emner (emnekode, emnenavn, foreleser, PIN) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $courseCode, $courseName, $_SESSION['email'], $coursePin);
                $stmt->execute();
            }
        }

        else {
            echo "nei";
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