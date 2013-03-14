<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
    define('SITE_ROOT', DS.'Users'.DS.'joss'.DS.'Sites'.DS.'japanese_tutor');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// japanese characters are 3 UTF-8 characters long
defined('J_SIZE') ? null : define('J_SIZE', 3);

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');

// load database-table classes
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'verb.php');

// load other objects
require_once(LIB_PATH.DS.'id_manager.php');
require_once(LIB_PATH.DS.'pagination.php');
require_once(LIB_PATH.DS.'playlist.php');

// initialise core objects
$database = new MySQLDatabase();
$session  = new Session();

?>