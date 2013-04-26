<?php

/**
 * Error
 *  * controls Errors
 */
class Error extends Controller {

    function __construct($errorNo, $details = "") {
        parent::__construct();
        require 'models/error.php';
        $errorModel = new ErrorModel($errorNo);
        $result = $errorModel -> getResult();
        $this -> view -> errorType = $result['0']['type'];
        $this -> view -> errorString = $result['0']['string'] . " : " . $details . ". ";
        $this -> view -> renderError();
    }

}
?>