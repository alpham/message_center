<?php
require 'index.php';

$message = array("to"=>"ahmed",
"from"=>1,
"subject"=>"hi ahmed ",
"body"=>"how are you ?? ",);

$msg = new Message();
if ($msg->send($message)) {
    echo "done :)";    
}


?>