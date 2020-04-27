<?php

class PinCode extends Model {

    private $course;
    private $correct;

    public function __construct(MySQLi $mysqli, string $code, bool $correct = false) {

        parent::__construct($mysqli);
        $this->course = $this->loadCourse($code);
        $this->correct = $correct;
    }

    public function loadCourse(string $code) {

        $code = stripslashes(trim(htmlspecialchars($code)));
        
        $stmt = $this->mysqli->prepare("SELECT emnekode, emnenavn, PIN FROM emner WHERE emnekode = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
        
    }

    public function submitPIN(string $pin) {

        $pin = stripslashes(trim(htmlspecialchars($pin)));
            
        $stmt = $this->mysqli->prepare("SELECT * FROM emner WHERE emnekode = ? AND PIN = ?");
        $stmt->bind_param("si", $this->course['emnekode'], $pin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            return new PinCode($this->mysqli, $this->course['emnekode'], true);
        }
        return new PinCode($this->mysqli, $this->course['emnekode']);
        
    }

    public function getCourse(): array {

        return $this->course;
    }

    public function isCorrectPIN() {

        return $this->correct;
    }

}

?>