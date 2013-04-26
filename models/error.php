<?php

/**
 * ErorrModel
 */
class ErrorModel extends Model {

    function __construct($errorNo) {
        parent::__construct();
        $this -> setTable('errors');
        $this -> setCondition('id = ' . $this  -> quote($errorNo));
        $result = $this -> getResult();
    }

}
