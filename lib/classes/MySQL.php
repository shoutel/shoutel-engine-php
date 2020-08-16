<?php

use Medoo\Medoo;

class MySql extends BaseApp
{
	public $database = null;

	public function __construct($conf = null)
	{
		if ($conf)
		{
			$dbms = $conf->dbms;
			$host = $conf->hostname;
			$user = $conf->username;
			$pass = $conf->password;
			$db   = $conf->db;
		}

		if (isset($dbms))
		{
			try
			{
				$this->database = new Medoo([
					'database_type' => $dbms,
					'database_name' => $db,
					'server' => $host,
					'username' => $user,
					'password' => $pass,
					'charset' => 'utf8mb4'
				]);
			}
			catch(Exception $e)
			{
				echo 'Can\'t connect to MySQL server!';
				exit();
			}
		}
	}
}
