<?php

/**
 * Login
 *  * a controller to manage user access to the system.
 */
class Login extends Controller {

    function __construct($username = NULL, $password = NULL) {
        parent::__construct();
        $this->view->page = "login";

        require_once 'models/user.php';
        if (isset($_POST['username'], $_POST['password'], $_POST['login']) && ($username === NULL && $password === NULL)) {
            $this->tryLogin($_POST);
        }

        $this->user = new User();
        if (isset($_POST['reg-username'],$_POST['reg-password'])) {
            $this->signup($_POST);
//            echo "signup";
//            exit;
        }
        if ($this->isActive()) {
            header("location:" . ABSOLUTE_PATH . "mail");
//            Bootstrap::boot();
        }
        $this->render();
    }

    public function signup($data) {
        if ($this->user->newUser($data)) {
            $data = array(
                'username' => $data['reg-username'],
                'password' => $data['reg-password'] == $data['reg-confirm'] ? $data['reg-password'] : NULL
            );
            $this->tryLogin($data);
        }
    }

    private function writeSession($data) {
        session_set_cookie_params(30 * 24 * 60 * 60);
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['avatar'] = $data['avatar'];
        $_SESSION['rememberMe'] = isset($_POST['remember']) ? 1 : 0;
        $_SESSION['settings'] = $this->user->loadSettings();
        header("location:" . ABSOLUTE_PATH . "mail");
    }

    public function getUser() {
        return $this->user;
    }

    public function render() {
        $this->view->renderView('login', true);
    }

    public function isActive() {
        return (isset($_SESSION['id']) && !empty($_SESSION['id']));
    }

    public function tryLogin($data) {
        $this->doLogin($data);
    }

    private function doLogin($data) {
        if (isset($data['username'])) {
            if (isset($data['password'])) {
                require_once 'models/user.php';
                $this->user = new User($data['username'], $data['password']);
                $this->userData = $this->user->getUser();
                if ($this->user->getUserId()) {
                    $this->writeSession($this->userData);
                    header("location:" . ABSOLUTE_PATH . "mail");
                }
            }
        }
    }

    private function loginError($errorNo) {
        require_once 'models/error.php';
        $err = new ErrorModel($errorNo);
    }

}