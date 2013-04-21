<?php

/**
 * View
 *  * letr's controle some views
 */
class View {

    function __construct() {

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
        $file = 'views/header.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $err = new Error(2);
        }
    }

    public function renderFooter() {
        $file = 'views/footer.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $err = new Error(2);
        }
    }

    public function renderPage($name, $noInclude = False) {
        if ($noInclude == FALSE) {
            $file = 'views/' . $name . '.php';
            if (file_exists($file)) {
                $this -> renderHeader();
                require $file;
                $this -> renderFooter();
            } else {
                $err = new Error(2);
            }

        } else {
            $file = 'views/' . $name . '.php';
            if (file_exists($file)) {
                // $this->renderHeader();
                require $file;
                // $this->renderFooter();
            } else {
                $err = new Error(2);
            }
        }
    }

}
?>