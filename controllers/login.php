<?php

/**
 * Login
 *  * a controller to manage user access to the system.
 */
class Login extends Controller {

    function __construct() {
        parent::__construct();
        $this->render();
    }

    public function render() {
        $this -> view -> renderPage('login/index', true);
    }

    /*
    public function isLogedIn($userId = 0) {
            if ($userId != 0) {
                start_session();
                if (isset($_SESSION['id'])&& $_SESSION['id'] == $userId) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
    
        }
     */
    

}
