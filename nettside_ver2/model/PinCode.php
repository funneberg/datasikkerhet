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
        $stmt = $this->mysqli->prepare("SELECT emnekode, emnenavn, PIN FROM emner WHERE emnekode = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function submitPIN(string $pin) {

        $coursePin = $course['pin'];

        if (password_verify($pin, $coursePin)) {
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