<?php

/**
 * Et view for en emneliste.
 */
class CourseListView extends View {

    /**
     * Viser emnelistesiden.
     */
    public function output(Model $model): void {

        // Henter alle emner.
        $courses = $model->getCourses();
        include_once("./pages/courseListPage.php");
    }

}

?>