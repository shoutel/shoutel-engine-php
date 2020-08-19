<?php

class DBSqlite extends BaseApp
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
			$db = $conf->db;
		}

		if (isset($dbms))
		{
			try
			{
				$dsn = 'sqlite:' . $db;
				return new PDO($dsn);
			}
			catch(PDOException $e)
			{
				echo 'Connection failed: ' . $e->getMessage();
				exit();
			}
		}
	}
}
