<?php

/**
 * Database
 *  * describe the database as an sub-object in our system
 */
class Database extends PDO {
    private $table, $condition;
    function __construct() {
        $this -> table = '';
        $this -> condition = '';

        parent::__construct(DB_DEVICE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    }

    public function setTable($table) {
        $this -> table = $table;
    }

    /*
     * setCondition($cond)
     *
     * * be careful and use this function carefully
     * * as it could be used in SQL injection
     * * NEVER pass arguments directly from the user ($_GET OR $_POST OR $_COOKIES)
     *
     * */
    public function setCondition($cond) {
        $this -> condition = $cond;
    }

    public function getResult($query = NULL, $command = "SELECT") {
        if ($query === NULL) {
            if ($command == "SELECT") {
                $sql = "SELECT * FROM " . $this -> table . " WHERE " . $this -> condition . " ;";
                $sSQL = 'SET CHARACTER SET utf8';
                $this -> exec($sSQL);
                $stm = $this -> query($sql);
                // $stm -> execute(array(":condition" => $this -> condition, ":table" => $this -> table));
                // print_r ($stm -> fetchAll());
                // echo $this->condition . $this->table;
                return $stm -> fetchAll();
            } else if ($command == "DELETE") {
                $sql = "DELETE FROM " . $this -> table . " WHERE " . $this -> condition . " ;";
                $sSQL = 'SET CHARACTER SET utf8';
                $this -> exec($sSQL);
                $stm = $this -> query($sql);
                $result = $stm -> rowCount() . "rows deleted.";
                return $result;

            }
        } else {
            $sSQL = 'SET CHARACTER SET utf8';
            $this -> exec($sSQL);
            $stm = $this -> query($query);
            return $stm -> fetchAll();
        }
    }

    public function getId($id, $table = Null) {
        if (isset($table) && !empty($table)) {
            $this -> setCondition(" id = " . $id);

            $result = $this -> getResult("SELECT");
            return $result;
        } else {
            $curTable = $this -> table;
            $this -> table = $table;
            $result = $this -> getResult("SELECT");
        }
    }

}
?>