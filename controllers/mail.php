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
        if (isset($_POST['send'])) {
            if (empty($_POST['to'])) {
                $err = new Error(8, "message destination is not defined !!");
                return FALSE;
            } else if (empty($_POST['subject'])) {
                $err = new Error(8, "message subject is not defined !!");
                return FALSE;
            } else {
                if ($this -> messages -> send($_POST)) {
                    $err = new Error(9, "message has been successfully delivered :)");
                    return FALSE;
                }
            }
        }
    }

    public function compose() {
        $this -> view -> page = "compose";
        $this -> redirect();
        $this -> view -> renderPage("mail/compose");
    }

    public function render() {
        $this -> view -> renderPage("main/index");
    }

    public function search($messageID = 0) {
        $this -> redirect();
        if (!$messageID > 0) {
            $this -> view -> page = "search";
            $this -> view -> renderPage("mail/search");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function inbox($messageID = 0) {
        $this -> redirect();
        if (!$messageID > 0) {
            $this -> view -> page = "inbox";
            $this -> view -> renderPage("mail/inbox");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function sentbox($messageID = 0) {
        $this -> redirect();
        if (!$messageID > 0) {
            $this -> view -> page = "sentbox";
            $this -> view -> renderPage("mail/sentbox");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function trash($messageID = 0) {
        $this -> redirect();
        if (!$messageID > 0) {
            $this -> view -> page = "trash";
            $this -> view -> renderPage("mail/trash");
        } else {
            $this -> loadMessage($messageID);
        }

    }

    public function redirect() {
        if (!Login::isActive()) {
            header("location:" . ABSOLUTE_PATH . "iuylogin");
        }
    }

    private function loadMessage($messageID) {
        $msg = new Message($messageID);
        return $msg -> getMessageById($messageID);
    }

}
