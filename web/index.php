<?php
/*
 *---------------------------------------------------------------
 * DEFINE SYSTEM ROOT FOLDER NAME
 *---------------------------------------------------------------
 * 
 * Define the root folder path.
 */
chdir(dirname(__DIR__));

require_once 	'vendor/autoload.php';
$app = require  'app/app.php';
require 		'app/config/config.php';
require 		'app/routes.php';

$app->run();