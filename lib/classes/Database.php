<?php

class Database extends BaseApp
{
	private static $conn = NULL;
	
	public static function init()
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
					$conn = $mysql->connection();
					self::$conn = $conn;
					break;
				case 'sqlite':
					$sqlite = new DBSqlite($conf);
					$conn = $sqlite->connection();
					self::$conn = $conn;
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
			$sth = self::$conn->prepare($query);
		}
		else
		{
			$sth = self::$conn->prepare(
				$query,
				array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
			);
		}

		if ($option)
		{
			$param_no = 1;

			foreach ($option as $k => $v)
			{
				if ($q)
				{
					if (gettype($v) == 'string')
					{
						$sth->bindValue($param_no, $v, PDO::PARAM_STR);
					}
					else
					{
						$sth->bindValue($param_no, $v, PDO::PARAM_INT);
					}
					$param_no++;
				}
				else
				{
					if (gettype($v) == 'string')
					{
						$sth->bindValue($k, $v, PDO::PARAM_STR);
					}
					else
					{
						$sth->bindValue($k, $v, PDO::PARAM_INT);
					}
				}
			}
		}

		$sth->execute();

		$err = $sth->errorInfo();

		$state = $err[0];
		$err_code = $err[1];
		$msg = $err[2];

		if ($state != 00000)
		{
			$err_msg = 'SQL Error ' . $err_code . ' (' . $state . '): ' . $msg;
			echo $err_msg;
			exit();
		}
		else
		{
			return $sth;
		}
	}
}

?>
