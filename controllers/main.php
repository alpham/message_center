<?php

/**
 * Main
 *  * index controller : controls what to be shown in the index page.
 */
class Main extends Controller {

    function __construct() {
        parent::__construct();
        $this -> redirect();
        require 'models/message.php';
        $this -> messages = new Message();

    }

    public function render() {
        $this -> view -> renderPage("main/index");
    }

    public function inbox() {
        $this -> view -> page = "inbox";
        $this -> redirect();
        $this -> view -> renderPage("mail/inbox");

    }

    public function redirect() {
        if (!$this -> check -> checkLog()) {
            header("location:" . ABSOLUTE_PATH . "login/");
        }
    }

}
