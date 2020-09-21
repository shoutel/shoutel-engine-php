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
		if (!isset($_SESSION[$key])) return null;

		return $_SESSION[$key];
	}

	public static function delete($key)
	{
		if (!isset($_SESSION)) return false;
		if (!isset($_SESSION[$key])) return null;

		unset($_SESSION[$key]);
		return true;
	}

	public static function destroy()
	{
		session_destroy();
		setcookie(self::$session_id, '', time() - 1);
	}

	public static function getToken()
	{
		if (!isset($_SESSION[CSRF_TOKEN_NAME])) return null;

		return $_SESSION[CSRF_TOKEN_NAME];
	}

	public static function verifyToken($token)
	{
		if (!isset($_SESSION[CSRF_TOKEN_NAME])) return false;
		if ($token !== $_SESSION[CSRF_TOKEN_NAME]) return false;

		$check_token = preg_match('/^[a-zA-Z0-9]+$/', $token);
		$token_len = strlen($token);
		if (!$check_token || $token_len != CsrfToken::getTokenLength())
		{
			return false;
		}

		return true;
	}
}
