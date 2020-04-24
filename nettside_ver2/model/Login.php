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

            // Prøver å logge inn som student.
            $this->loginStudent($user);

            // Prøver å logge inn som foreleser.
            $this->loginLecturer($user);

            // Prøver å logge inn som administrator.
            $this->loginAdmin($user);
        }

        return new Login($this->mysqli);
    }

    /**
     * Logger inn en student hvis brukeren finnes i tabellen for studenter.
     */
    private function loginStudent(array $user): void {
        $stmt = $this->mysqli->prepare("SELECT navn, epost FROM student WHERE epost = ? AND passord = ?");
        $stmt->bind_param("ss", $user['email'], $user['password']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_array();

            $_SESSION['loggedIn'] = true;
            $_SESSION['student'] = true;
            $_SESSION['name'] = $student[0];
            $_SESSION['email'] = $student[1];
        }
    }

    /**
     * Logger inn en foreleser hvis brukeren finnes i tabellen for forelesere.
     */
    private function loginLecturer(array $user): void {
        $stmt = $this->mysqli->prepare("SELECT navn, epost FROM foreleser WHERE epost = ? AND passord = ?");
        $stmt->bind_param("ss", $user['email'], $user['password']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $lecturer = $result->fetch_array();

            $_SESSION['loggedIn'] = true;
            $_SESSION['lecturer'] = true;
            $_SESSION['name'] = $lecturer[0];
            $_SESSION['email'] = $lecturer[1];
        }
    }

    /**
     * Logger inn en foreleser hvis brukeren finnes i tabellen for administratorer.
     */
    private function loginAdmin(array $user): void {
        $stmt = $this->mysqli->prepare("SELECT brukernavn FROM admin WHERE brukernavn = ? AND passord = ?");
        $stmt->bind_param("ss", $user['email'], $user['password']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_array();

            $_SESSION['loggedIn'] = true;
            $_SESSION['admin'] = true;
            $_SESSION['name'] = $admin[0];
        }
    }

}

?>