<?php

/**
 * User
 *  * this class describes the user as an object in our little system :)
 */
class User extends Model {

    private $user;

    // $user is an array which contains all user data retrieved form users table.

    function __construct($username = NULL, $password = NULL) {
        parent::__construct();
        $this->doLogin($username, $password);
    }

    public function newUser($data) {
        if ($data['reg-username'] && $data['reg-password'] && $data['reg-password'] === $data['reg-confirm']) {
            $query = "INSERT INTO users (username,password) VALUES (" . $this->quote($data['reg-username']) . ",MD5(" . $this->quote($data['reg-password']) . "))";
            $sSql = "SET CHARSET utf8";
            $this->exec($sSql);
            $count = $this->exec($query);
            $id = $this->lastInsertId();
            $query = "INSERT INTO settings (user_id) VALUES (" . $this->quote($id) . ")";
            $this->exec($query);
            if ($count) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    private function doLogin($username, $password) {
        // session_start();
        if ($username != NULL && $password != NULL) {
            $log = new Check();
            if ($log->checkLog()) {
                $this->user = $this->getUserById($_SESSION['id']);
            } else {
                $this->setTable('users');
                $this->setCondition('username = ' . $this->quote($username) . " AND password = MD5(" . $this->quote($password) . ") ;");
                $this->user = $this->getResult();

                $count = $this->countDb();
                if ($count != 1) {
                    require_once 'controllers/error.php';
                    $err = new Error(10);
                    header("location:" . ABSOLUTE_PATH . "login");
                } else {
                    $this->user = $this->user['0'];
                }
            }
        } else if (isset($_POST['password'], $_POST['username']) && ($username == NULL || $password == NULL)) {
            header("location:" . ABSOLUTE_PATH . "login");
        }
    }

    public function loadSettings() {
        $query= defined("USER_ID") ? "SELECT * FROM settings WHERE user_id = " . $this->quote(USER_ID): NULL;
        $res= !empty($query) ? $this->query($query) : NULL;
        $res = !empty($res) ? $res->fetchAll['0'] : NULL;
        return $res;
        
    }

    public function getUserId() {
        return isset($this->user['id']) ? $this->user['id'] : NULL;
    }

    public function getUser() {
        return $this->user;
    }

    public function getCurrentUserId() {
        return isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = " . $this->quote($id);
        $result = $this->query($query);
        $result = $result->fetchAll();
        $result = $result['0'];
        return $result;
    }

    public function getUserByName($username) {
        $query = "SELECT * FROM users WHERE username = " . $this->quote($username);
        $result = $this->query($query);
        $result = $result->fetchAll();
        $result = $result['0'];
        return $result;
    }

    public function isLoggedIn($id) {
        if (isset($_SESSION['id'])) {
            if ($_SESSION['id'] == $id) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}

?>