<?php

define("USER_ID", 1);
// load application configuration
require 'config/database.php';
require 'config/paths.php';
require 'config/parameters.php';


// load application libraries
require 'libs/database.php';
require 'libs/functions.php';
require 'libs/controller.php';
require 'libs/views.php';
require 'libs/model.php';
require 'libs/bootstrap.php';
require 'libs/check.php';

$app = new Bootstrap();

/////////////////////
/*

$message = array("to"=>"ahmed,ahmed1",
"from"=>1,
"subject"=>"hi ahmed ",
"body"=>"how are you ?? ",);

$msg = new Message();
$id = 1;
if ($msg->delete($id) ){
    echo "done :) delete id= " . $msg->getID() ." by " . $id;    
}
////////////////////////////*/

?>