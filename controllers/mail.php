<?php

/**
 * Main
 *  * index controller : controls what to be shown in the index page.
 */
class Mail extends Controller {

    function __construct() {
        parent::__construct();
        $this -> redirect();
        require 'models/message.php';
        $this -> messages = new Message();

    }

    public function render() {
        $this -> view -> renderPage("main/index");
    }

    public function inbox($messageID = 0) {
        if (!$messageID > 0) {
            $this -> view -> page = "inbox";
            $this -> redirect();
            $this -> view -> renderPage("mail/inbox");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function sentbox($messageID = 0) {
        if (!$messageID > 0) {
            $this -> view -> page = "sentbox";
            $this -> redirect();
            $this -> view -> renderPage("mail/sentbox");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function trash($messageID = 0) {
        if (!$messageID > 0) {
            $this -> view -> page = "trash";
            $this -> redirect();
            $this -> view -> renderPage("mail/trash");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function redirect() {
        if (!$this -> check -> checkLog()) {
            header("location:" . ABSOLUTE_PATH . "login/");
        }
    }
    
    private function loadMessage($messageID)
    {
        $msg = new Message($messageID);
        return $msg->getMessageById($messageID);
    }

}
