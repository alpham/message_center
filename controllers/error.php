<?php



/**
 * Error
 *  * controls Errors 
 */
class Error extends Controller {
	    
	
	function __construct($errorNo,$details = "") {
	    parent::__construct();
        $this->db->setTable('errors');
        $this->db->setCondition( 'id = ' . $this->db->quote($errorNo) );
        $result = $this->db->getResult();
        // print_r($result) ;
        $this->view->errorString = $result['0']['string'] . " : " . $details.". ";
        $this->view->renderPage("error/error");
	}
}


?>