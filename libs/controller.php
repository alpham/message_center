<?php

/**
 * Controller
 *  * the parent controller of all of our controllers
 */
class Controller {

    function __construct() {
        // session_start();
        $this -> check = new Check();
        $this -> view = new View();

    }

}
