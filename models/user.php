<?php

/**
 * User
 *  * this class describes the user as an object in our little system :)
 */
class User extends Model {
    
    private $user; // $user is an array which contains all user data retrieved form users table.
	
	function __construct( $username , $password ) {
	    parent::__construct();
        
        $this->doLogin($username, $password);
		
	}
    
    private function doLogin($username , $password)
    {
        session_start();
        $log = new Check();
        if ($log->checkLog()) {
            $this->user = $this->getUserById($_SESSION['id']);
        } else {
            $this-> setTable('users');
            $this->setCondition('user = '.$this->quote($username));
             
        }
    }
    
    public function loadSession()
    {
        
    }
    
    public function getUserId()
    {
        
    }
    
    public function getUserById($id)
    {
        
    }
    
    public function getUserByName($username)
    {
        
    }
    
    public function isLoggedIn($id)
    {
        
    }
    
    
    
}


?>