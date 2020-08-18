<?php

class DBSqlite extends BaseApp
{
	public $database = null;

	public function init($conf = null)
	{
		if ($conf)
		{
			$dbms = $conf->dbms;
			$db   = $conf->db_path;
		}

		if (isset($dbms))
		{
			try
			{
				$dsn = 'sqlite:' . $db;
				$this->database = new PDO($dsn);
			}
			catch(PDOException $e)
			{
				echo 'Connection failed: ' . $e->getMessage();
				exit();
			}
		}
	}
}
