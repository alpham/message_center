<?php

/**
 * Bootstrap
 *  * control what to be displayed on index page
 */
class Bootstrap {

    function __construct() {
        session_start();
        define("PRO_TITLE", "Message Center");

        require_once 'controllers/login.php';
//        $login = new Login();
//        session_start();
        $url = prepareURL($_GET);
        if (Login::isActive()) {
            if (!defined('USER_ID') && isset($_SESSION['id'])) {
                define('USER_ID', $_SESSION['id']);
            }
        } else {
            if ($url[0] != "login") {
                header("location:" . ABSOLUTE_PATH . "login");
            }
            $login = new Login();
        }
        if (Check::checkLog()) {
            $set = $this->loadSettings();
            define("MESSAGES_PER_PAGE", $set['messages_per_page']);
        }
        $this->boot();
    }

    public function loadSettings() {
        $db = new Database();
        $userID = defined("USER_ID") ? USER_ID : 0;
        if (defined("USER_ID")) {
            $userID = $db->quote($userID);
            $query = "SELECT * FROM settings WHERE user_id = " . $userID;
            $result = $db->query($query);
            $result = $result->fetchAll();
            return $result['0'];
        } else {
            return NULL;
        }
    }

    public function boot() {
        if (defined("USER_ID")) {
            $url = prepareURL($_GET);
            if (empty($url['0'])) {
                header("location:" . ABSOLUTE_PATH . "mail/inbox");
                return FALSE;
            }
            require_once 'controllers/error.php';
            $file = 'controllers/' . $url['0'] . '.php';

            if (file_exists($file)) {
                require_once $file;
                $controller = new $url['0'];
                if ($url['0'] == "mail") {
                    if (!isset($url['1'])) {
                        header("location:" . ABSOLUTE_PATH . "mail/inbox");
                    }
                }

                if (isset($url['2']) && !empty($url['2'])) {
                    if (isset($url['1'])) {
                        if (method_exists($controller, $url['1'])) {
                            $controller->{$url['1']}($url['2']);
                        } else {
                            $err = new Error(4, "no method " . $url['1'] . " available in class " . $url['0']);
                            return FALSE;
                        }
                    }
                }
                if (isset($url['1'])) {
                    if (method_exists($controller, $url['1'])) {
                        $controller->{$url['1']}();
                    } else {
                        $err = new Error(4, "no method " . $url['1'] . " available in class " . $url['0']);
                        return FALSE;
                    }
                }
            } else {
                // echo "here" ;
                // header("location:" . ABSOLUTE_PATH . "mail/inbox");
                $error = new Error(1, "no class " . $url['0'] . " available.");
                return FALSE;
            }
        }
    }

}

?>