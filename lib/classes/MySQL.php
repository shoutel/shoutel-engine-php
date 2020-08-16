<?php

use Medoo\Medoo;

class MySql
{
  public $database = null;

  public function __construct($config = array())
  {
    if (!empty($config)) {
      $host = $config['db_host_name'];
      $user = $config['db_username'];
      $pass = $config['db_password'];
      $db   = $config['db_name'];
    } else {
      $host = DB_HOST_NAME;
      $user = DB_USERNAME;
      $pass = DB_PASSWORD;
      $db   = DB_NAME;
    }

	$this->database = new Medoo([
		'database_type' => 'mysql',
		'database_name' => $db,
		'server' => $host,
		'username' => $user,
		'password' => $pass,
		'charset' => 'utf8mb4'
	]);
  }
}
