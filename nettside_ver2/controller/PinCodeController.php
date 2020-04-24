<?php

/**
 * En Controller for PIN-koder.
 */
class PinCodeController extends Controller {

    /**
     * Sender inn en PIN-kode som brukeren har skrevet inn.
     */
    public function submitPIN(Course $model): Course {
        return $model->submitPIN($_POST['PIN']);
    }

}

?>