<?php

/**
 * En model for et emne.
 */
class Course extends Model {

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, string $code, array $response = []) {
        parent::__construct($mysqli, $logger);
        $course = $this->loadCourse($code);
        $this->response = array_replace($response, $course);
        $this->response['inquiries'] = $this->loadInquiries($code);
    }

    /**
     * Lagrer en henvendelse fra en student i databasen.
     */
    public function saveStudentInquiry(array $inquiry): Course {

        if (!empty($inquiry['inquiry']) && !empty($inquiry['user']) && preg_match('/^[A-Za-z0-9_~\-!@#?.\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\) ]+$/', $inquiry['inquiry'])) {

            $inquiry1 = stripslashes(trim(htmlspecialchars($inquiry['inquiry'])));
            $user = stripslashes(trim(htmlspecialchars($inquiry['user'])));

            $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (avsender_student, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user, $this->course['epost'], $this->course['emnekode'], $inquiry1);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Henvendelse sendt";
                $this->logger->info('En student sendte en henvendelse.', ['brukernavn' => $user, 'henvendelse' => $inquiry['inquiry']]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Henvendelsen ble ikke sendt";
                $this->logger->info('En student prøvde å sende en henvendelse. Forsøk mislykket.', ['brukernavn' => $user, 'henvendelse' => $inquiry['inquiry']]);
            }

        }
        else {
            $response['error'] = true;
            $response['message'] = "Tomt tekstfelt";
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode'], $response);
    }

    /**
     * Lagrer en henvendelse fra en gjest i databasen.
     */
    public function saveGuestInquiry(array $inquiry): Course {

        if (!empty($inquiry['inquiry']) && !empty($inquiry['user']) && preg_match('/^[A-Za-z0-9_~\-!@#?.\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\) ]+$/', $inquiry['inquiry'])) {

            $inquiry1 = stripslashes(trim(htmlspecialchars($inquiry['inquiry'])));
            $user = stripslashes(trim(htmlspecialchars($inquiry['user'])));

            $stmt = $this->mysqli->prepare("INSERT INTO henvendelse (avsender_gjest, mottaker, emnekode, henvendelse) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $inquiry['user'], $this->course['epost'], $this->course['emnekode'], $inquiry1);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Henvendelse sendt";
                $this->logger->info('En gjest sendte en henvendelse.', ['brukernavn' => $user, 'henvendelse' => $inquiry1]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Henvendelsen ble ikke sendt";
                $this->logger->info('En gjest prøvde å sende en henvendelse. Forsøk mislykket.', ['brukernavn' => $user, 'henvendelse' => $inquiry1]);
            }

        }
        else {
            $response['error'] = true;
            $response['message'] = "Tomt tekstfelt";
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode'], $response);
    }

    /**
     * Lagrer svaret fra en foreleser i databasen.
     */
    public function saveReply(array $reply): Course {

        if (!empty($reply['comment']) && !empty($reply['user']) && preg_match('/^[A-Za-z0-9_~\-!@#?.\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\) ]+$/', $reply['comment'])) {

            $replyId = stripslashes(trim(htmlspecialchars($reply['id'])));
            $replyC = stripslashes(trim(htmlspecialchars($reply['comment'])));
            $replyUser = stripslashes(trim(htmlspecialchars($reply['user'])));

            $stmt = $this->mysqli->prepare("UPDATE henvendelse SET svar = ? WHERE id = ?");
            $stmt->bind_param("si", $replyC, $replyId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Svar sendt";
                $this->logger->item('Foreleser svarte på en henvendelse.', ['foreleser' => $replyUser, 'id' => $replyId, 'svar' => $replyC]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Svar ble ikke sendt";
                $this->logger->info('Foreleser prøvde å svare på en henvendelse. Forsøk mislykket.', ['foreleser' => $replyUser, 'id' => $replyId, 'svar' => $replyC]);
            }

        }
        else {
            $response['error'] = true;
            $response['message'] = "Tomt tekstfelt";
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode'], $response);
    }

    /**
     * Lagrer en kommentar fra en student i databasen.
     */
    public function saveStudentComment(array $comment): Course {

        if (!empty($comment['id']) && !empty($comment['comment']) && !empty($comment['user']) && preg_match('/^[A-Za-z0-9_~\-!@#?.\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\) ]+$/', $comment['comment'])) {

            $commentC = stripslashes(trim(htmlspecialchars($comment['comment'])));
            $commentId = stripslashes(trim(htmlspecialchars($comment['id'])));
            $commentUser = stripslashes(trim(htmlspecialchars($comment['user'])));

            $stmt = $this->mysqli->prepare("INSERT INTO kommentar (avsender_student, kommentar_til, kommentar) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $commentUser, $commentId, $commentC);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Kommentar sendt";
                $this->logger->info('En student sendte en kommentar til en henvendelse.', ['brukernavn' => $commentUser, 'kommentar' => $commentC]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Kommentar ble ikke sendt";
                $this->logger->info('En student prøvde å sende en kommentar til en henvendelse. Forsøk mislykket.', ['brukernavn' => $commentUser, 'kommentar' => $commentC]);
            }

        }
        else {
            $response['error'] = true;
            $response['message'] = "Tomt tekstfelt";
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode'], $response);
    }

    /**
     * Lagrer en kommentar fra en gjest i databasen.
     */
    public function saveGuestComment(array $comment): Course {

        if (!empty($comment['id']) && !empty($comment['comment']) && !empty($comment['user']) && preg_match('/^[A-Za-z0-9_~\-!@#?.\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\) ]+$/', $comment['comment'])) {

            $commentC = stripslashes(trim(htmlspecialchars($comment['comment'])));
            $commentId = stripslashes(trim(htmlspecialchars($comment['id'])));
            $commentUser = stripslashes(trim(htmlspecialchars($comment['user'])));

            $stmt = $this->mysqli->prepare("INSERT INTO kommentar (avsender_gjest, kommentar_til, kommentar) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $commentUser, $commentId, $commentC);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Kommentar sendt";
                $this->logger->info('En gjest sendte en kommentar til en henvendelse.', ['brukernavn' => $commentUser, 'kommentar' => $commentC]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Kommentar ble ikke sendt";
                $this->logger->info('En gjest prøvde å sende en kommentar til en henvendelse. Forsøk mislykket.', ['brukernavn' => $commentUser, 'kommentar' => $commentC]);
            }

        }
        else {
            $response['error'] = true;
            $response['message'] = "Tomt tekstfelt";
        }

        return new Course($this->mysqli, $this->logger, $this->course['emnekode'], $response);
    }

    /**
     * Rapporterer en henvendelse.
     */
    public function reportInquiry(array $report): Course {

        $response = array();
        if (!empty($report['id']) && !empty($report['user'])) {

            $id = stripslashes(trim(htmlspecialchars($report['id'])));
            $user = stripslashes(trim(htmlspecialchars($report['user'])));

            $stmt = $this->mysqli->prepare("UPDATE henvendelse SET rapportert = rapportert + 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Henvendelse rapportert";
                $this->logger->info('Bruker rapporterte en henvendelse.', ['brukernavn' => $user, 'id' => $id]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Noe gikk galt";
            }
        }
        else {
            $response['error'] = true;
            $response['message'] = "Noe gikk galt";
        }

        return new Course($this->mysqli, $this->logger, $this->response['emnekode'], $response);
    }

    /**
     * Rapporterer en kommentar.
     */
    public function reportComment(array $report): Course {

        $response = array();
        if (!empty($report['id']) && !empty($report['user'])) {

            $id = stripslashes(trim(htmlspecialchars($report['id'])));
            $user = stripslashes(trim(htmlspecialchars($report['user'])));

            $stmt = $this->mysqli->prepare("UPDATE kommentar SET rapportert = rapportert + 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['error'] = false;
                $response['message'] = "Kommentar rapportert";
                $this->logger->info('Bruker rapporterte en kommentar.', ['brukernavn' => $user, 'id' => $id]);
            }
            else {
                $response['error'] = true;
                $response['message'] = "Noe gikk galt";
            }
        }
        else {
            $response['error'] = true;
            $response['message'] = "Noe gikk galt";
        }

        return new Course($this->mysqli, $this->logger, $this->response['emnekode'], $response);
    }

    /**
     * Laster inn emnet fra databasen.
     */
    private function loadCourse(string $code): array {

        if (preg_match("/^[A-Z]+(|-[A-Z]+)[0-9]+$/", $code)) {

            $code = stripslashes(trim(htmlspecialchars($code)));

            $stmt = $this->mysqli->prepare("SELECT emnekode, emnenavn, PIN, navn, epost, bilde FROM emner, foreleser WHERE epost = foreleser AND emnekode = ?");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }

        }

        $this->logger->info('Bruker prøvde å gå til et emne som ikke finnes.', ['emnekode' => $code]);

        return [];
    }

    /**
     * Laster inn henvendelsene til emnet.
     */
    private function loadInquiries(string $code): array {

        $inquiries = [];

        if (preg_match("/^[A-Z]+(|-[A-Z]+)[0-9]+$/", $code)) {

            $code = stripslashes(trim(htmlspecialchars($code)));

            $stmt = $this->mysqli->prepare("SELECT * FROM henvendelse WHERE emnekode = ? ORDER BY id DESC");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $result = $stmt->get_result();

            while($inquiry = $result->fetch_assoc()) {
                $inquiry['comments'] = $this->loadComments($inquiry['id']);
                $inquiries[] = $inquiry;
            }
        }
        return $inquiries;
    }

    /**
     * Laster inn kommentarene til en henvendelse.
     */
    private function loadComments(int $id): array {

        $comments = [];

        if (preg_match("/^[0-9]*$/", $id)) {

            $id = stripslashes(trim(htmlspecialchars($id)));

            $stmt = $this->mysqli->prepare("SELECT * FROM kommentar WHERE kommentar_til = ? ORDER BY id DESC");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($comment = $result->fetch_assoc()) {
                $comments[] = $comment;
            }
        }
        return $comments;
    }

    public function isNotCourseLecturer(array $user) {
        if (isset($user['lecturer'])) {
            if ($user['user'] == $this->course['epost']) {
                return false;
            }

            $this->logger->info('Foreleser prøvde å gå til et emne som de ikke har tilgang til.', ['foreleser' => $user['user'], 'emnekode' => $this->response['emnekode']]);
        
            return true;
        }

        return false;
    }

    /**
     * Sjekker om en PIN-kode er riktig.
     */
    public function isCorrectPIN(int $pin): bool {

        if (preg_match("/^[0-9 ]*$/", $pin) && strlen($pin) == 4) {

            $pinHash = $this->course['PIN'];
            return password_verify($pin, $pinHash);

        }
        return false;
    }

}

?>