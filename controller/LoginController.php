<?php

/**
 * En Controller for login.
 */
class LoginController extends Controller {

    /**
     * Logger inn en bruker.
     */
    public function signIn(Login $model): Login {
        
        return $model->signIn($_POST);
    }
    
}

?>