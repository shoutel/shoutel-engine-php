<?php

class CsrfToken
{
	private static $token_length = 32;

	private static $token = null;

	public static function init()
	{
		if (!Session::getToken()) self::create();
		self::$token = Session::getToken();
	}

	public static function check()
	{
		if (get_method() === 'GET')
		{
			return false;
		}
		if (isset($_SERVER['HTTP_X_CSRF_TOKEN']))
		{
			return Session::verifyToken($_SERVER['HTTP_X_CSRF_TOKEN']);
		}
		elseif (isset($_REQUEST['_sht_csrf_token']))
		{
			return Session::verifyToken($_REQUEST['_sht_csrf_token']);
		}
		elseif ($token = json_value('_sht_csrf_token'))
		{
			return Session::verifyToken($token);
		}

		return false;
	}

	public static function get()
	{
		return self::$token;
	}

	public static function getTokenLength()
	{
		return self::$token_length;
	}

	public static function create()
	{
		$token = self::token_rnd(self::getTokenLength());
		self::$token = $token;
		Session::set(CSRF_TOKEN_NAME, $token);
	}

	private static function token_rnd($l) {
		$rand_str_arr = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
							  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
							  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
							  'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd',
							  'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
							  'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
							  'y', 'z');

		$random = '';

		for($i = 1; $i <= $l; $i++)
		{
			$random .= $rand_str_arr[mt_rand(0,61)];
		}

		return $random;
	}
}
