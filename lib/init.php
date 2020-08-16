<?php

define('__SHT__', true);
define('SHT_VERSION', '0.1');

define('PROJECT_ROOT', realpath(dirname(__FILE__) . '/..'));
define('TEMPLATES_ROOT', PROJECT_ROOT . '/templates/');
define('VIEW_ROOT', PROJECT_ROOT . '/app/View/');
define('DATA_ROOT', PROJECT_ROOT . '/data/');

define('COMMON_VIEW_PATH', VIEW_ROOT . 'commons/');
define('ERROR_VIEW_PATH', VIEW_ROOT . 'errors/');

define('DEFAULT_CLASS', 'bulletin');
define('DEFAULT_HOME', 'index');

$chk_install = new stdClass();
$chk_install->default_config = DATA_ROOT . 'config/default_config.php';
$chk_install->database = DATA_ROOT . 'config/database.php';

$conf_exists = file_exists($chk_install->default_config);
$db_conf_exists = file_exists($chk_install->database);

if ($conf_exists && $db_conf_exists)
{
	require_once(DATA_ROOT . 'config/default_config.php');
	require_once(DATA_ROOT . 'config/database.php');
}

require_once(PROJECT_ROOT . '/vendor/autoload.php');
require_once(PROJECT_ROOT . '/lib/functions.php');

$path = array(
  PROJECT_ROOT . '/lib/core/',
  PROJECT_ROOT . '/lib/classes/',
  PROJECT_ROOT . '/app/Model/',
  PROJECT_ROOT . '/app/Controller/',
  PROJECT_ROOT . '/app/View/'
);

spl_autoload_register('load_class');
error_reporting(E_ALL | E_NOTICE);
