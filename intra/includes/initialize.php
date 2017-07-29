<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
	define('SITE_ROOT', 'C:'.DS.'Program Files (x86)'.DS.'Zend'.DS.'Apache2'.DS.'htdocs'.DS.'intra');

defined('LIB_PATH') ? null :
	define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once("session.php");
require_once("database.php");
require_once("databaseObject.php");
require_once("config.php");
require_once("user.php");
?>