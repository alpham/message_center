<?php

// load application configuration
require 'config/database.php';
require 'config/paths.php';
require 'config/parameters.php';


// load application libraries
require 'libs/database.php';
require 'libs/controller.php';
require 'libs/views.php';
require 'libs/model.php';
require 'libs/bootstrap.php';
require 'libs/check.php';

$app = new Bootstrap();
?>