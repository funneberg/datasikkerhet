<?php

/**
 * Et view for admin.
 */
class AdminView extends View {

    /**
     * Viser adminsiden.
     */
    public function output(Model $model): void {
        
        // Henter forelesere som ikke er godkjente.
        $lecturers = $model->getResponse();
        include_once('./pages/adminPage.php');
    }

}