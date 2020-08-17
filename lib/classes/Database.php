<?php

class Database extends BaseApp
{
	private $conn = NULL;
	
	public function __construct()
	{
		if (defined('DB_SYSTEM'))
		{
			$dbms = DB_SYSTEM;
			$conf = new stdClass();
			$conf->dbms = $dbms;

			if ($dbms != 'sqlite')
			{
				$hostname = DB_HOST_NAME;
				$username = DB_USERNAME;
				$password = DB_PASSWORD;
				$db = DB_NAME;

				$conf->hostname = $hostname;
				$conf->username = $username;
				$conf->password = $password;
				$conf->db = $db;
			}
			else
			{
				$conf->db_path = DB_PATH;
			}

			switch ($dbms)
			{
				case 'mysql':
					$mysql = new DBMySql($conf);
					$this->conn = $mysql->database;
					break;
				case 'sqlite':
					$sqlite = new DBSqlite($conf);
					$this->conn = $sqlite->database;
					break;
				default:
					echo 'The database configuration file is invalid.';
					exit();
			}
		}
	}

	public function dbQuery($query, $option = null, $q = true)
	{
		if ($q)
		{
			$sth = $this->conn->prepare($query);
		}
		else
		{
			$sth = $this->conn->prepare(
				$query,
				array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
			);
		}

		$sth->execute($option);

		$err = $sth->errorInfo();

		$state = $err[0];
		$err_code = $err[1];
		$msg = $err[2];

		if ($state != 00000)
		{
			$err_msg = 'SQL Error ' . $err_code . ' (' . $state . '): ' . $msg;
			$this->showError(500, $err_msg);
		}
		else
		{
			return $sth;
		}
	}
}

?>
