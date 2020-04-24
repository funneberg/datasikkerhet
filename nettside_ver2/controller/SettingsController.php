<?php

/**
 * En controller for innstillinger.
 */
class SettingsController extends Controller {

    /**
     * Endrer passordet til en bruker.
     */
    public function changePassword(Settings $model): Settings {
        
        // Endrer passordet til en student.
        if (isset($_SESSION['student'])) {
            $model = $model->changeStudentPassword($_POST);
        }
        // Endrer passordet til en foreleser.
        else if (isset($_SESSION['foreleser'])) {
            $model = $model->changeLecturerPassword($_POST);
        }
        return $model;
    }
    
}

?>