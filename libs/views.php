<?php

/**
 * View
 *  * letr's controle some views
 */
class View {

    function __construct() {
        $theme = "views/" . $this -> getTheme() . "/";
        if(!defined("THEME_FOLDER")){
            define("THEME_FOLDER", $theme);
        }
    }

    /*
     public function render($page) {
     $file = 'views/' . $page . '.php';
     if (file_exists($file)) {
     require $file;
     } else {
     $error = new Error(2);
     }
     }*/

    public function renderHeader() {
        $file = THEME_FOLDER . 'header.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $err = new Error(2);
        }
    }

    public function renderSidebar() {
        $file = THEME_FOLDER . 'sidebar.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $err = new Error(2);
        }
    }

    public function renderFooter() {
        $file = THEME_FOLDER . 'footer.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $err = new Error(2);
        }
    }

    public function renderPage($name, $noInclude = False) {
        if ($noInclude == FALSE) {
            $file = THEME_FOLDER . $name . '.php';
            if (file_exists($file)) {
                $this -> renderHeader();
                $this -> renderSidebar();
                require $file;
                $this -> renderFooter();
            } else {
                $err = new Error(2);
            }

        } else {
            $file = THEME_FOLDER . $name . '.php';
            if (file_exists($file)) {
                // $this->renderHeader();
                require $file;
                // $this->renderFooter();
            } else {
                $err = new Error(2);
            }
        }
    }
    
    public function renderError()
    {
        $this->renderHeader();
        $this->renderSidebar();
        $this->renderPage("mail/inbox",TRUE);
        $this->renderPage("error/error",TRUE);
        $this->renderFooter();
    }
    
    public function setActive($page) {
        if (isset($this -> page)) {
            if ($this -> page == $page) {
                echo "active";
            }
        }

    }

    public function getTheme() {
        $db = new Database();
        $query = "SELECT theme FROM settings WHERE user_id = " . USER_ID;
        $result = $db -> query($query);
        return $result -> fetchColumn();

    }

    public function getMessagesOf($cat) {
        require_once 'models/message.php';
        $msg = new Message();
        $url=prepareURL($_GET);
        $messageID = isset($url['2']) ? $url['2'] : 0;
        if (!$messageID > 0) {
            $style = file_get_contents(THEME_FOLDER . "mail/components/table-cells.php");
            $table = file_get_contents(THEME_FOLDER . "mail/components/table.php");
            $msg = $msg -> {"get".$cat}();
            $message_table = $table;
            foreach ($msg as $key => $value) {
                $message_view = "";
                $modified_table = $message_table;
                foreach ($value as $key1 => $val) {
                    $message_view = str_replace("%body%", substr($msg[$key]['body'], 0, 200) . "...", $style);
                    $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                    $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                    $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                    $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $cat . "/" . $msg[$key]['id'], $message_view);
                }
                $message_table = str_replace("%message_cells%", $message_view . " %message_cells% ", $modified_table);
            }
            $message_table = str_replace(" %message_cells% ", "", $message_table);
            echo $message_table;
        } else {
            $style = file_get_contents(THEME_FOLDER . "mail/components/message.php");
            $msg = $msg -> {"get".$cat}($messageID);
            foreach ($msg as $key => $value) {
                $message_view = "";
                foreach ($value as $key1 => $val) {
                    $message_view = str_replace("%body%", substr($msg[$key]['body'], 0, 200) . "...", $style);
                    $message_view = str_replace("%time%", $msg[$key]['time'], $message_view);
                    $message_view = str_replace("%subject%", $msg[$key]['subject'], $message_view);
                    $message_view = str_replace("%sender%", $msg[$key]['sender_name'], $message_view);
                    $message_view = str_replace("%view_message_url%", ABSOLUTE_PATH . "mail/" . $cat . "/" . $msg[$key]['id'], $message_view);
                }
                echo $message_view;
            }
        }

    }

}
?>