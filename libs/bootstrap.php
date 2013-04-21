<?php

/**
 * Bootstrap
 *  * control what to be displayed on index page
 */
class Bootstrap {

    function __construct() {
        $db = new Database();

        $url = isset($_GET['url']) ? $_GET['url'] : Null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        print_r($url);
        if (empty($url['0'])) {
            require 'controllers/main.php';
            $controller = new Main();
            $controller -> inbox();
            return FALSE;
        }

        $file = 'controllers/' . $url['0'] . '.php';

        if (file_exists($file)) {
            require $file;
            // echo "hi there :) <p>";
            $controller = new $url['0'];
            if ($url['0'] == "main") {
                $controller -> inbox();
            }
            if (isset($url['2'])) {
                if (isset($url['1'])) {
                    if (method_exists($controller, $url['1'])) {
                        $controller -> {$url['1']}($url['2']);
                    } else {
                        $err = new Error(4,"no method ".$url['1']." available in class ".$url['0']);

                    }
                } else {
                    if (method_exists($controller, $url['1'])) {
                        $controller -> {$url['1']}();
                    } else {
                        $err = new Error(4,"no method ".$url['1']." vailable in class ".$url['0']);

                    }
                }
            }
        } else {
            require 'controllers/error.php';
            $error = new Error(1,"no class ".$url['0']." available.");
        }

    }

}
?>