<?php

/**
 * Et view for en emneliste.
 */
class CourseListView extends View {

    /**
     * Viser emnelistesiden.
     */
    public function output(Model $model): void {

        echo $_POST['searchTerm'];

        // Henter alle emner.
        $courses = $model->getCourses();
        include_once("./pages/courseListPage.php");
    }

}

?>