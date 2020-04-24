<?php

/**
 * En Controller for emner.
 */
class CourseController extends Controller {

    /**
     * Sender inn en henvendelse fra brukeren.
     */
    public function submitInquiry(Course $model): Course {
        return $model->saveInquiry($_POST);
    }

    /**
     * Sender inn en kommentar fra brukeren.
     */
    public function submitComment(Course $model): Course {
        return $model->saveComment($_POST);
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