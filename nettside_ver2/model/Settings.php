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
        if ($passwords['newPasswordFirst'] == $passwords['newPasswordSecond'] && !empty($passwords['newPasswordFirst'])) {
            $stmt = $this->mysqli->prepare("UPDATE student SET passord = ? WHERE epost = ? AND passord = ?");
            $stmt->bind_param("sss", $passwords['newPasswordFirst'], $_SESSION['email'], $passwords['oldPassword']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return new Settings($this->mysqli, true);
            }
        }
        return new Settings($this->mysqli);
    }

    /**
     * Endrer passordet til en foreleser.
     */
    public function changeLecturerPassword($passwords): Settings {
        if ($passwords['newPasswordFirst'] == $passwords['newPasswordSecond']) {
            $stmt = $this->mysqli->prepare("UPDATE foreleser SET passord = ? WHERE epost = ? AND passord = ?");
            $stmt->bind_param("sss", $passwords['newPasswordFirst'], $_SESSION['email'], $passwords['oldPassword']);
            $stmt->execute();
            if ($stmt->affected_rows() > 0) {
                return new Settings($this->mysqli, true);
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