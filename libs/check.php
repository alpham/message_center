<?php

/**
 *
 */
class Check {

    function __construct() {
        $this -> checkLog();
    }

    public function checkLog() {
        //session_start();
        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    
    

}
