<?php

class DBMySql extends BaseApp
{
	private $conf = NULL;

	public function __construct($conf = null)
	{
		$this->conf = $conf;
	}

	public function connection()
	{
		$conf = $this->conf;

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
				return new PDO($dsn, $user, $pass);
			}
			catch(PDOException $e)
			{
				echo 'Connection failed: ' . $e->getMessage();
				exit();
			}
		}
	}
}
