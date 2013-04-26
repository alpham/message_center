<?php

/**
 *
 */
class Check {

    function __construct() {

    }

    public function checkLog() {
        //session_start();
        if (isset($_SESSION['id'])) {
            return TRUE;
        } else {
            return TRUE; 
        }

    }

}
