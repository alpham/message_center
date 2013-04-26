<?php

/**
 * Bootstrap
 *  * control what to be displayed on index page
 */
class Bootstrap {

    function __construct() {

        $url = prepareURL($_GET);
        // print_r($url);
        if (empty($url['0'])) {
            header("location:" . ABSOLUTE_PATH . "mail/inbox");
            return FALSE;
        }
        require 'controllers/error.php';
        $file = 'controllers/' . $url['0'] . '.php';

        if (file_exists($file)) {
            require $file;
            $controller = new $url['0'];
            if ($url['0'] == "mail") {
                if (!isset($url['1'])) {
                    header("location:" . ABSOLUTE_PATH . "mail/inbox");
                }
            }
            if (isset($url['2']) && !empty($url['2'])) {
                if (isset($url['1'])) {
                    if (method_exists($controller, $url['1'])) {
                        $controller -> {$url['1']}($url['2']);
                    } else {
                        $err = new Error(4, "no method " . $url['1'] . " available in class " . $url['0']);
                        return FALSE;
                    }
                }
            }
            if (isset($url['1'])) {
                if (method_exists($controller, $url['1'])) {
                    $controller -> {$url['1']}();
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
?>