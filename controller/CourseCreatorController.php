<?php

/**
 * En Controller for å lage et emne.
 */
class CourseCreatorController extends Controller {

    /**
     * Oppretter et nytt emne.
     */
    public function createCourse(CourseCreator $model): CourseCreator {
        
        return $model->createCourse($_POST);
    }

}

?>