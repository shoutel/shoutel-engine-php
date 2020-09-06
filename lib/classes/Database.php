<?php

class Database extends BaseApp
{
	private static $conn = NULL;
	private static $connSlave = NULL;

	private $query = NULL;
	private $option = NULL;
	private $q = true;

	public $cacheName = NULL;

	public static function init($is_master = false)
	{
		if (defined('DB_SYSTEM'))
		{
			$dbms = DB_SYSTEM;
			$conf = new stdClass();
			$conf->dbms = $dbms;

			if ($dbms != 'sqlite')
			{
				if ($is_master)
				{
					$hostname = DB_HOST_NAME;
				}
				else
				{
					$hostname = DB_SLAVE_HOST_NAME;
				}

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

					if (DB_HOST_NAME == DB_SLAVE_HOST_NAME)
					{
						self::$conn = $conn;
						self::$connSlave = $conn;
					}
					else
					{
						if ($is_master)
							self::$conn = $conn;
						else
							self::$connSlave = $conn;
					}

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

	public function dbQueryExecute($conn)
	{
		$query = $this->query;
		$option = $this->option;
		$q = $this->q;

		if ($q)
		{
			$sth = $conn->prepare($query);
		}
		else
		{
			$sth = $conn->prepare(
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

	public function dbQuery($query, $option = null, $q = true)
	{
		// select
		$select = startsWith(strtolower($query), 'select');

		if (!$select)
		{
			if (self::$conn === null)
				self::init(true);

			$conn = self::$conn;
		}
		else
		{
			if (self::$connSlave === null)
				self::init();

			$conn = self::$connSlave;
		}

		$this->query = $query;
		$this->option = $option;
		$this->q = $q;

		$execute = $this->dbQueryExecute($conn);

		return $execute;
	}
}

?>
