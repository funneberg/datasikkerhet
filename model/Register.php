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

        if (!empty($student['name']) && !empty($student['email']) && !empty($student['fieldOfStudy']) && !empty($student['year']) && !empty($student['password'])) {

            $name = stripslashes(trim(htmlspecialchars($student['name'])));
            $email = stripslashes(trim(htmlspecialchars($student['email'])));
            $fieldOfStudy = stripslashes(trim(htmlspecialchars($student['fieldOfStudy'])));
            $year = stripslashes(trim(htmlspecialchars($student['year'])));

            if (preg_match("/^[a-zA-Z ]*$/" , $name) && preg_match("/^[a-zA-Z ]*$/" , $fieldOfStudy) && filter_var($email, FILTER_VALIDATE_EMAIL) 
                && preg_match("/^[0-9 ]*$/" , $year))  {

                $password = stripslashes(trim(htmlspecialchars(password_hash($student['password'], PASSWORD_DEFAULT))));

                if (!$this->userExists($email)) {

                    $stmt = $this->mysqli->prepare("INSERT INTO student (navn, epost, studieretning, kull, passord) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssis", $name, $email, $fieldOfStudy, $year, $password);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['student'] = true;
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                    }
                }  
            }  
            
            else {
                echo "nei";
            }
        }

        return new Register($this->mysqli);
    }

    /**
     * Registrerer en foreleser til databasen hvis brukeren ikke finnes fra før.
     */
    public function registerLecturer(array $lecturer): Register {

        if (!empty($lecturer['name']) && !empty($lecturer['email']) && !empty($lecturer['password'] && !empty($lecturer['image']))) {

            $name = stripslashes(trim(htmlspecialchars($lecturer['name'])));
            $email = stripslashes(trim(htmlspecialchars($lecturer['email'])));

            if (preg_match("/^[a-zA-Z ]*$/" , $name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $password = stripslashes(trim(htmlspecialchars(password_hash($lecturer['password'], PASSWORD_DEFAULT))));

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
                        $_SESSION['email'] = $email;
                    }
                }
            }
            
        }

        return new Register($this->mysqli);
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

        $email = stripslashes(trim(htmlspecialchars($email)));

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

        $email = stripslashes(trim(htmlspecialchars($email)));

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

        $email = stripslashes(trim(htmlspecialchars($email)));
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