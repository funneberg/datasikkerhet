<?php

/**
 * En model for innstillinger.
 */
class Settings extends Model {

    private $changed = false;

    public function __construct(MySQLi $mysqli, bool $changed = false) {
        parent::__construct($mysqli);
        $this->changed = $changed;
    }

    /**
     * Endrer passordet til en student.
     */
    public function changeStudentPassword($passwords): Settings {
        $email = $_SESSION['email'];

        $stmt = $this->mysqli->prepare("SELECT passord FROM student WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            $oldPassword = $passwords['oldPassword'];
            $pwHash = $student['passord'];

            // Sjekker at passordet er riktig.
            if (password_verify($oldPassword, $pwHash)) {

                $newPassword1 = $passwords['newPasswordFirst'];
                $newPassword2 = $passwords['newPasswordSecond'];

                // Sjekker at det nye passordet er fyllt ut riktig i begge feltene.
                if ($newPassword1 == $newPassword2 && !empty($newPassword1)) {
                    $newPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

                    $stmt = $this->mysqli->prepare("UPDATE student SET passord = ? WHERE epost = ?");
                    $stmt->bind_param("ss", $newPassword, $email);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        return new Settings($this->mysqli, true);
                    }
                }
            }
        }
        return new Settings($this->mysqli);
    }

    /**
     * Endrer passordet til en foreleser.
     */
    public function changeLecturerPassword($passwords): Settings {
        $email = $_SESSION['email'];

        $stmt = $this->mysqli->prepare("SELECT passord FROM foreleser WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $lecturer = $result->fetch_assoc();

            $oldPassword = $passwords['oldPassword'];
            $pwHash = $lecturer['passord'];

            // Sjekker om brukeren har skrevet inn riktig passord.
            if (password_verify($oldPassword, $pwHash)) {

                $newPassword1 = $passwords['newPasswordFirst'];
                $newPassword2 = $passwords['newPasswordSecond'];

                // Sjekker at det nye passordet er fyllt ut riktig i begge feltene.
                if ($newPassword1 == $newPassword2 && !empty($newPassword1)) {
                    $newPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

                    $stmt = $this->mysqli->prepare("UPDATE foreleser SET passord = ? WHERE epost = ?");
                    $stmt->bind_param("ss", $newPassword, $email);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        return new Settings($this->mysqli, true);
                    }
                }
            }
        }
        return new Settings($this->mysqli);
    }

    /**
     * Sjekker om passordet ble endret.
     */
    public function isPasswordChanged(): bool {
        return $this->changed;
    }
}

?>