<?php

class DBMySql extends BaseApp
{
	public $database = null;

	public function init($conf = null)
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
				$dsn = 'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8mb4';
				$this->database = new PDO($dsn, $user, $pass);
			}
			catch(PDOException $e)
			{
				echo 'Connection failed: ' . $e->getMessage();
				exit();
			}
		}
	}
}
