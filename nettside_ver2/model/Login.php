<?php

/**
 * En modell for login.
 */
class Login extends Model {

    /**
     * Logger brukeren inn.
     */
    public function signIn(array $user): Login {

        if (!empty($user['email']) && !empty($user['password'])) {

            if (preg_match('/^[A-Za-z0-9_~\-!@#\$%\Æ\Ø\Å\æ\ø\å\^&\*\(\)]+$/', $user['password']) && filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {

                // Prøver å logge inn som student.
                if ($this->loginStudent($user)) {
                    return new Login($this->mysqli, $this->logger);
                }

                // Prøver å logge inn som foreleser.
                else if ($this->loginLecturer($user)) {
                    return new Login($this->mysqli, $this->logger);
                }

                // Prøver å logge inn som administrator.
                else if ($this->loginAdmin($user)) {
                    return new Login($this->mysqli, $this->logger);
                }
            }

            else{
                echo("bruker har skrivd inn ugyldige tegn");
                $this->logger->warning("Bruker skrev inn ugyldig tegn i innloggingsfeltet.", ['brukernavn' => $user['email']]);
            }
        }

        $this->logger->info("Bruker ble ikke logget inn. Innlogging mislykket.", ['brukernavn' => $user['email']]);

        return new Login($this->mysqli, $this->logger);
    }

    /**
     * Logger inn en student hvis brukeren finnes i tabellen for studenter.
     */
    private function loginStudent(array $user): bool {

        $email = trim($user['email']);
        $password = trim($user['password']);

        $stmt = $this->mysqli->prepare("SELECT navn, passord FROM student WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Sjekker om det ble returnert en student.
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $name = $student['navn'];
            $pwHash = $student['passord'];

            if (password_verify($password, $pwHash)) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['student'] = true;
                $_SESSION['name'] = $name;
                $_SESSION['user'] = $email;

                $this->logger->info("Student ble logget inn.", ['brukernavn' => $email]);

                return true;
            }
        }

        return false;
    }

    /**
     * Logger inn en foreleser hvis brukeren finnes i tabellen for forelesere.
     */
    private function loginLecturer(array $user): bool {
       
        $email = trim($user['email']);
        $password = trim($user['password']);

        $stmt = $this->mysqli->prepare("SELECT navn, passord FROM foreleser WHERE epost = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Sjekker om det ble returnert en foreleser.
        if ($result->num_rows > 0) {
            $lecturer = $result->fetch_assoc();
            $name = $lecturer['navn'];
            $pwHash = $lecturer['passord'];

            // Sjekker om passordet er riktig.
            if (password_verify($password, $pwHash)) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['lecturer'] = true;
                $_SESSION['name'] = $name;
                $_SESSION['user'] = $email;

                $this->logger->info("Foreleser ble logget inn.", ['brukernavn' => $email]);

                return true;
            }
        }

        return false;
    }

    /**
     * Logger inn en foreleser hvis brukeren finnes i tabellen for administratorer.
     */
    private function loginAdmin(array $user): bool {
        
        $email = trim($user['email']);
        $password = trim($user['password']);

        $stmt = $this->mysqli->prepare("SELECT passord FROM admin WHERE brukernavn = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $pwHash = $admin['passord'];

            if (password_verify($password, $pwHash)) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['admin'] = true;
                $_SESSION['name'] = $email;

                $this->logger->info("Admin ble logget inn.", ['brukernavn' => $email]);

                return true;
            }
        }
        return false;
    }

}

?>