<?php header("Content-Type: text/html;charset=UTF-8");

// define("USER_ID", isset($_SESSION['id']) ? $_SESSION['id'] : 0);

//define("USER_ID", 1);

// load application configuration
require 'config/database.php';
require 'config/paths.php';
require 'config/parameters.php';

// load application libraries
require_once 'libs/database.php';
require 'libs/controller.php';
require 'libs/views.php';
require 'libs/model.php';
require 'libs/bootstrap.php';
require 'libs/check.php';

// $user = new Login();
// define("USER_ID", 6);

$app = new Bootstrap();

/////////////////////
/*
 $message = array("to" => "admin,ahmed1", "from" => 2, "subject" => "ازيكم  ", "body" => "عاملين إيه ؟؟<br /> يارب تكونوا كويسين  :)", );

 $msg = new Message();
 $id = 1;
 $i=0;
 while ($i <5){
 $msg -> send($message);
 $i++;
 }*/

// print_r($_GET);

////////////////////////////
?>