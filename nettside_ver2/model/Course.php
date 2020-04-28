<?php

/**
 * En model for et emne.
 */
class Course extends Model {

    private $course;
    private $inquiries;

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, string $code) {
        parent::__construct($mysqli, $logger);
        $this->course = $this->loadCourse($code);
        $this->inquiries = $this->loadInquiries($code);
    }

    /**
     * Lagrer en henvendelse fra en student i databasen.
     */
    public function saveStudentInquiry(array $inquiry): Course {
        $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (avsender_student, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $_SESSION['user'], $this->course['epost'], $this->course['emnekode'], $inquiry['inquiry']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->logger->info('En student sendte en henvendelse.', ['brukernavn' => $_SESSION['user'], 'henvendelse' => $inquiry['inquiry']]);
        }
        else {
            $this->logger->info('En student prøvde å sende en henvendelse. Forsøk mislykket.', ['brukernavn' => $_SESSION['user'], 'henvendelse' => $inquiry['inquiry']]);
        }

        

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Lagrer en henvendelse fra en gjest i databasen.
     */
    public function saveGuestInquiry(array $inquiry): Course {
        $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (avsender_gjest, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $_SESSION['user'], $this->course['epost'], $this->course['emnekode'], $inquiry['inquiry']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->logger->info('En gjest sendte en henvendelse.', ['brukernavn' => $_SESSION['user'], 'henvendelse' => $inquiry['inquiry']]);
        }
        else {
            $this->logger->info('En gjest prøvde å sende en henvendelse. Forsøk mislykket.', ['brukernavn' => $_SESSION['user'], 'henvendelse' => $inquiry['inquiry']]);
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Lagrer svaret fra en foreleser i databasen.
     */
    public function saveResponse(array $response): Course {
        $stmt = $this->mysqli->prepare("UPDATE henvendelse SET svar = ? WHERE id = ?");
        $stmt->bind_param("si", $response['comment'], $response['id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->logger->item('Foreleser svarte på en henvendelse.', ['foreleser' => $_SESSION['user'], 'id' => $response['id'], 'svar' => $response['svar']]);
        }
        else {
            $this->logger->info('Foreleser prøvde å svare på en henvendelse. Forsøk mislykket.', ['foreleser' => $_SESSION['user'], 'id' => $response['id'], 'svar' => $response['svar']]);
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Lagrer en kommentar fra en student i databasen.
     */
    public function saveStudentComment(array $comment): Course {
        $stmt = $this->mysqli->prepare("INSERT INTO kommentar (avsender_student, kommentar_til, kommentar) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $_SESSION['user'], $comment['id'], $comment['comment']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->logger->info('En student sendte en kommentar til en henvendelse.', ['brukernavn' => $_SESSION['user'], 'kommentar' => $comment['comment']]);
        }
        else {
            $this->logger->info('En student prøvde å sende en kommentar til en henvendelse. Forsøk mislykket.', ['brukernavn' => $_SESSION['user'], 'kommentar' => $comment['comment']]);
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Lagrer en kommentar fra en gjest i databasen.
     */
    public function saveGuestComment(array $comment): Course {
        $stmt = $this->mysqli->prepare("INSERT INTO kommentar (avsender_gjest, kommentar_til, kommentar) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $_SESSION['user'], $comment['id'], $comment['comment']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->logger->info('En gjest sendte en kommentar til en henvendelse.', ['brukernavn' => $_SESSION['user'], 'kommentar' => $comment['comment']]);
        }
        else {
            $this->logger->info('En gjest prøvde å sende en kommentar til en henvendelse. Forsøk mislykket.', ['brukernavn' => $_SESSION['user'], 'kommentar' => $comment['comment']]);
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Rapporterer en henvendelse.
     */
    public function reportInquiry(int $id): Course {
        $stmt = $this->mysqli->prepare("UPDATE henvendelse SET rapportert = 1 WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $this->logger->info('Bruker rapporterte en henvendelse.', ['brukernavn' => $_SESSION['user'], 'id' => $id]);

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Rapporterer en kommentar.
     */
    public function reportComment(int $id): Course {
        $stmt = $this->mysqli->prepare("UPDATE kommentar SET rapportert = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $this->logger->info('Bruker rapporterte en kommentar.', ['brukernavn' => $_SESSION['user'], 'id' => $id]);

        return new Course($this->mysqli, $this->logger, $this->course['emnekode']);
    }

    /**
     * Laster inn emnet fra databasen.
     */
    private function loadCourse(string $code): array {
        $stmt = $this->mysqli->prepare("SELECT emnekode, emnenavn, PIN, navn, epost, bilde FROM emner, foreleser WHERE epost = foreleser AND emnekode = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        $this->logger->info('Bruker prøvde å gå til et emne som ikke finnes.', ['emnekode' => $code]);

        return [];
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

    public function isLecturerButNotCourseLecturer() {
        if (isset($_SESSION['lecturer'])) {
            if ($_SESSION['user'] == $this->course['epost']) {
                return false;
            }

            $this->logger->info('Foreleser prøvde å gå til et emne som de ikke har tilgang til.', ['foreleser' => $_SESSION['user'], 'emnekode' => $this->course['emnekode']]);
        
            return true;
        }

        return false;
    }

    /**
     * Sjekker om en PIN-kode er riktig.
     */
    public function isCorrectPIN(int $pin): bool {
        $pinHash = $this->course['PIN'];
        return password_verify($pin, $pinHash);
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