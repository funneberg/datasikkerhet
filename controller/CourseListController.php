<?php

/**
 * En Controller for emnelister.
 */
class CourseListController extends Controller {
    
    /**
     * Søker etter et bestemt søkeord i emnelisten.
     */
    public function search(CourseList $model): CourseList {

        if (!empty($_POST['searchTerm'])) {

            $model = $model->search($_POST['searchTerm']);
        }
        
        return $model;
    }

}

?>