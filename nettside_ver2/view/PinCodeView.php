<?php

/**
 * Et view for en PIN-kode.
 */
class PinCodeView extends View {

    /**
     * Viser siden hvor man skriver inn en PIN-kode til et emne.
     */
    public function output(Model $model): void {
        // Henter info om emnet.
        $course = $model->getCourse();

        if (empty($course)) {
            http_response_code(404);
            die;
        }

        // Hvis PIN-koden er riktig, blir man omdirigert til siden for emnet.
        if (isset($_POST['PIN'])) {
            if ($model->isCorrectPIN($_POST['PIN'])) {
                // Lagrer den riktige PIN-koden i sesjonen.
                $_SESSION['access'][$course['emnekode']] = $_POST['PIN'];
                header("location: index.php?page=course&code=".$course['emnekode']);
                die;
            }
        }
        $course = $model->getCourse();
        include_once("./pages/pinCodePage.php");
    }

}

?>