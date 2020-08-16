<?php

define('PROJECT_ROOT', realpath(dirname(__FILE__) . '/..'));
define('TEMPLATES_ROOT'   , PROJECT_ROOT . '/templates/');
define('VIEW_ROOT'   , PROJECT_ROOT . '/app/View/');

define('COMMON_VIEW_PATH', VIEW_ROOT . 'commons/');
define('ERROR_VIEW_PATH' , VIEW_ROOT . 'errors/');

define('DEFAULT_CLASS' , 'bulletin');
define('DEFAULT_HOME' , 'index');

require_once(PROJECT_ROOT . '/vendor/autoload.php');
require_once(PROJECT_ROOT . '/config/database.php');
require_once(PROJECT_ROOT . '/lib/functions.php');

date_default_timezone_set('Asia/Seoul');

$path = array(
  PROJECT_ROOT . '/lib/core/',
  PROJECT_ROOT . '/lib/classes/',
  PROJECT_ROOT . '/app/Model/',
  PROJECT_ROOT . '/app/Controller/',
  PROJECT_ROOT . '/app/View/'
);

spl_autoload_register('load_class');
error_reporting(E_ALL | E_NOTICE);
