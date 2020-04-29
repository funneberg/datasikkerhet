<?php

/**
 * En modell for registrering.
 */
class Register extends Model {

    private const dir = "./bilder/";

    /**
     * Registrerer en student hvis brukeren ikke finnes i databasen fra før.
     */
    public function registerStudent(array $student): Register {
        if (!empty($student['name']) && !empty($student['email']) && !empty($student['fieldOfStudy']) &&
            !empty($student['year']) && !empty($student['password'])) {

            $name = trim($student['name']);
            $email = trim($student['email']);
            $fieldOfStudy = trim($student['fieldOfStudy']);
            $year = trim($student['year']);

            if (preg_match("/^[a-zA-Z \æ\ø\å\Æ\Ø\Å ]*$/" , $name) && preg_match("/^[a-zA-Z \æ\ø\å\Æ\Ø\Å ]*$/" , $fieldOfStudy) && filter_var($email, FILTER_VALIDATE_EMAIL) 
                && preg_match("/^[0-9 ]*$/" , $year) && strlen($year) == 4 && $year <= date("Y"))  {

                $password = password_hash($student['password'], PASSWORD_DEFAULT);

                if (!$this->userExists($email)) {
                    $stmt = $this->mysqli->prepare("INSERT INTO student (navn, epost, studieretning, kull, passord) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssis", $name, $email, $fieldOfStudy, $year, $password);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['student'] = true;
                        $_SESSION['name'] = $name;
                        $_SESSION['user'] = $email;

                        $this->logger->info('Ny student ble registrert.', ['Brukernavn' => $email]);
                    }
                }
            }
            else {
                $this->logger->warning('Bruker prøvde å skrive inn et ulovlig tegn.', ['brukernavn' => $email]);
            }
        }
        else {
            $this->logger->info('Student ble ikke registrert.');
        }

        return new Register($this->mysqli, $this->logger);
    }

    /**
     * Registrerer en foreleser til databasen hvis brukeren ikke finnes fra før.
     */
    public function registerLecturer(array $lecturer): Register {

        if (!empty($lecturer['name']) && !empty($lecturer['email']) && !empty($lecturer['password'] && !empty($lecturer['image']))) {

            $name = trim($lecturer['name']);
            $email = trim($lecturer['email']);

            if (preg_match("/^[a-zA-Z \æ\ø\å\Æ\Ø\Å ]*$/"  , $name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $password = trim(password_hash($lecturer['password'], PASSWORD_DEFAULT));

                $image = $lecturer['image'];

                // Sjekker om brukeren finnes fra før, og om bildefilen er gyldig.
                if (!$this->userExists($email) && $this->isLegalFile($image)) {

                    // Lager et nytt navn til bildet.
                    $fileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                    $file = Register::dir.hash("sha256", uniqid()).".".$fileType;

                    // Endrer navnet på nytt hvis det allerede finnes et bilde med det nye navnet.
                    while (file_exists($file)) {
                        $file = Register::dir.hash("sha256", uniqid()).".".$fileType;
                    }

                    $fileName = basename($file);

                    $stmt = $this->mysqli->prepare("INSERT INTO foreleser (navn, epost, passord, bilde) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $email, $password, $fileName);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        move_uploaded_file($image['tmp_name'], $file);

                        $_SESSION['loggedIn'] = true;
                        $_SESSION['lecturer'] = true;
                        $_SESSION['name'] = $name;
                        $_SESSION['user'] = $email;

                        $this->logger->info('Ny foreleser ble registrert.', ['brukernavn' => $email]);
                    }
                }
            }
            else {
                $this->logger->warning('Bruker prøvde å skrive inn et ulovlig tegn.', ['brukernavn' => $email]);
            }
        }
        else {
            $this->logger->info('Foreleser ble ikke registrert.');
        }

        return new Register($this->mysqli, $this->logger);
    }

    /**
     * Sjekker om en fil er et bilde.
     */
    private function isLegalFile(array $file): bool {
        $targetFile = Register::dir.$file['name'];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($file['tmp_name']);

        if ($check != false) {
            if ($file['size'] > 500000) {
                return false;
            }
    
            if ($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "gif") {
                return false;
            }
            return true;
        }

        $this->logger->info('Bruker prøvde å laste opp en ugyldig fil.', ['filnavn' => $file['name']]);

        return false;
    }

    /**
     * Sjekker om brukeren man prøver å registrere allerede finnes i databasen.
     */
    public function userExists(string $email): bool {

        $email = stripslashes(trim(htmlspecialchars($email)));

        if ($this->isStudent($email)) {
            return true;
        }
        if ($this->isLecturer($email)) {
            return true;
        }
        if ($this->isAdmin($email)) {
            return true;
        }
        return false;
    }

    /**
     * Sjekker om brukeren man prøver å registrere allerede finnes i studenttabellen.
     */
    private function isStudent(string $email): bool {

        $stmt = $this->mysqli->prepare("SELECT navn FROM student WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Sjekker om brukeren man prøver å registrere allerede finnes i forelesertabellen.
     */
    private function isLecturer(string $email): bool {

        $stmt = $this->mysqli->prepare("SELECT navn FROM foreleser WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Sjekker om brukeren man prøver å registrere allerede finnes i admintabellen.
     */
    private function isAdmin(string $email): bool {

        $stmt = $this->mysqli->prepare("SELECT brukernavn FROM admin WHERE brukernavn = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

}

?>