<?php

class Database
{
	public $db = NULL;
	
	public function __construct()
	{
		if (defined('DB_SYSTEM'))
		{
			$dbms = DB_SYSTEM;
			$hostname = DB_HOST_NAME;
			$username = DB_USERNAME;
			$password = DB_PASSWORD;
			$db = DB_NAME;
			
			$conf = new stdClass();
			$conf->dbms = $dbms;
			$conf->hostname = $hostname;
			$conf->username = $username;
			$conf->password = $password;
			$conf->db = $db;
			
			switch ($dbms)
			{
				case 'mysql':
					
					$mysql = new MySql($conf);
					$this->db = $mysql->database;
					break;
				default:
					echo 'The database configuration file is invalid.';
					exit();
			}
		}
	}
}

?>
