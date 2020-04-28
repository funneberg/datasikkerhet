<?php

/**
 * En Controller for emner.
 */
class CourseController extends Controller {

    /**
     * Sender inn en henvendelse fra brukeren.
     */
    public function submitInquiry(Course $model): Course {
        if (isset($_SESSION['student'])) {
            $model = $model->saveStudentInquiry($_POST);
        }
        else if (isset($_SESSION['guest'])) {
            $model = $model->saveGuestInquiry($_POST);
        }
        return $model;
    }

    /**
     * Sender inn en kommentar fra brukeren.
     */
    public function submitComment(Course $model): Course {
        $course = $model->getCourse();
        $lecturer = $course['epost'];
        if (isset($_SESSION['lecturer']) && $_SESSION['user'] == $lecturer) {
            $model = $model->saveResponse($_POST);
        }
        else if (isset($_SESSION['student'])) {
            $model = $model->saveStudentComment($_POST);
        }
        else if (isset($_SESSION['guest'])) {
            $model = $model->saveGuestComment($_POST);
        }
        return $model;
    }

    /**
     * Rapporterer en henvendelse.
     */
    public function reportInquiry(Course $model): Course {
        return $model->reportInquiry($_POST['id']);
    }

    /**
     * Rapporterer en kommentar.
     */
    public function reportComment(Course $model): Course {
        return $model->reportComment($_POST['id']);
    }
    
}

?>