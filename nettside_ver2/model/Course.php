<?php

/**
 * En model for et emne.
 */
class Course extends Model {

    private $course;
    private $inquiries;

    public function __construct(MySQLi $mysqli, string $code) {
        parent::__construct($mysqli);
        $this->course = $this->loadCourse($code);
        $this->inquiries = $this->loadInquiries($code);
    }

    /**
     * Lagrer en henvendelse i databasen.
     */
    public function saveInquiry(array $inquiry): Course {
        if (isset($_SESSION['email'])) {
            $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (avsender, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $_SESSION['email'], $this->course['epost'], $this->course['emnekode'], $inquiry['inquiry']);
        }
        else {
            $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (mottaker, emnekode, henvendelse) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $this->course['epost'], $this->course['emnekode'], $inquiry['inquiry']);
        }
        $stmt->execute();
        return new Course($this->mysqli, $this->course['emnekode']);
    }

    /**
     * Lagrer en kommentar i databasen.
     */
    public function saveComment(array $comment): Course {
        if (isset($_SESSION['email'])) {
            $stmt = $this->mysqli->prepare("INSERT INTO kommentar (avsender, kommentar_til, kommentar) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $_SESSION['email'], $comment['id'], $comment['comment']);
        }
        else {
            $stmt = $this->mysqli->prepare("INSERT INTO kommentar (kommentar_til, kommentar) VALUES (?, ?)");
            $stmt->bind_param("is", $comment['id'], $comment['comment']);
        }
        $stmt->execute();
        return new Course($this->mysqli, $this->course['emnekode']);
    }

    /**
     * Rapporterer en henvendelse.
     */
    public function reportInquiry(int $id): Course {
        $stmt = $this->mysqli->prepare("UPDATE henvendelse SET rapportert = 1 WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return new Course($this->mysqli, $this->course['emnekode']);
    }

    /**
     * Rapporterer en kommentar.
     */
    public function reportComment(int $id): Course {
        $stmt = $this->mysqli->prepare("UPDATE kommentar SET rapportert = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return new Course($this->mysqli, $this->course['emnekode']);
    }

    /**
     * Laster inn emnet fra databasen.
     */
    private function loadCourse(string $code): array {
        $stmt = $this->mysqli->prepare("SELECT emnekode, emnenavn, PIN, navn, epost, bilde FROM emner, foreleser WHERE epost = foreleser AND emnekode = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Laster inn henvendelsene til emnet.
     */
    private function loadInquiries(string $code): array {
        $stmt = $this->mysqli->prepare("SELECT * FROM henvendelse WHERE emnekode = ? ORDER BY id DESC");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $inquiries = [];
        while($inquiry = $result->fetch_assoc()) {
            $inquiry['comments'] = $this->loadComments($inquiry['id']);
            $inquiries[] = $inquiry;
        }
        return $inquiries;
    }

    /**
     * Laster inn kommentarene til en henvendelse.
     */
    private function loadComments(int $id): array {
        $stmt = $this->mysqli->prepare("SELECT * FROM kommentar WHERE kommentar_til = ? ORDER BY id DESC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = [];
        while($comment = $result->fetch_assoc()) {
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Sjekker om en PIN-kode er riktig.
     */
    public function isCorrectPIN(int $pin): bool {
        return $this->course['PIN'] == $pin;
    }

    /**
     * Returnerer emnet.
     */
    public function getCourse(): array {
        return $this->course;
    }

    /**
     * Returnerer henvendelsene til emnet.
     */
    public function getInquiries(): array {
        return $this->inquiries;
    }

}

?>