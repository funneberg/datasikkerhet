<?php

/**
 * Et view for registrering.
 */
class RegisterView extends View {

    /**
     * Viser siden for registrering.
     */
    public function output(Model $model): void {
        // Hvis man allerede er logget inn, har man ikke tilgang til denne siden.
        if (isset($_SESSION['loggedIn'])) {
            header("location: index.php");
            die;
        }
        /*
        $registration = [];
        if (isset($_POST)) {
            $registration = $_POST;
        }
        if (isset($_FILES['image'])) {
            $registration['image'] = $_FILES['image'];
        }
        */
        include_once("./pages/registerPage.php");
    }

}

?>