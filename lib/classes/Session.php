<?php

class Session
{
	private static $session_id = 'SHT_SESSION';

	public static function start()
	{
		session_name(self::$session_id);
		session_start();

		if (!isset($_SESSION))
		{
			echo '<span style="color:red;font-weight:700">WARNING!</span> Session not initialized.';
			exit();
		}
	}

	public static function set($key, $val)
	{
		if (!isset($_SESSION)) return false;

		$_SESSION[$key] = $val;
		return true;
	}

	public static function get($key)
	{
		if (!isset($_SESSION)) return false;

		return $_SESSION[$key];
	}

	public static function destroy()
	{
		session_destroy();
		setcookie(self::$session_id, '', time() - 1);
	}
}
