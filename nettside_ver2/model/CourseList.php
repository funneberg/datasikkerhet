<?php

/**
 * En modell for en emneliste.
 */
class CourseList extends Model {

    private $courses = [];

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, bool $search = false, $courses = []) {
        parent::__construct($mysqli, $logger);
        
        if ($search) {
            $this->courses = $courses;
        }
        else {
            $this->courses = $this->loadCourses();
        }
    }

    /**
     * Laster inn alle emner fra databasen.
     */
    public function loadCourses(): array {
        $stmt = $this->mysqli->prepare("SELECT emner.*, navn FROM emner, foreleser WHERE foreleser = epost");
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = [];
        while($course = $result->fetch_assoc()) {
            $courses[] = $course;
        }
        return $courses;
    }

    /**
     * Henter alle emnene fra databasen som inneholder et søkeord.
     */
    public function search(string $searchTerm): CourseList {
        $search = '%'.$searchTerm.'%';
        $stmt = $this->mysqli->prepare("SELECT emner.*, navn FROM emner JOIN foreleser ON foreleser = epost 
                                        WHERE emnekode LIKE ? OR emnenavn LIKE ? OR foreleser LIKE ? OR navn LIKE ?");
        $stmt->bind_param("ssss", $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $courses = [];
        while($course = $result->fetch_assoc()) {
            $courses[] = $course;
        }

        $this->logger->info('Bruker søkte etter søkeord.', ['søkeord' => $searchTerm]);

        return new CourseList($this->mysqli, $this->logger, true, $courses);
    }

    /**
     * Returnerer emnene.
     */
    public function getCourses() {
        return $this->courses;
    }

}

?>