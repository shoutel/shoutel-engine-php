<?php

function sanitize($str, $flags = ENT_QUOTES, $encode = 'UTF-8')
{
	return htmlentities(stripslashes($str), $flags, $encode);
}

function format_date($param, $format = 'd-m-Y H:i')
{
	return date($format, strtotime($param));
}

function load_class($class) {
	global $path;

	foreach($path as $dir) {
		$filename = $dir. $class . '.php';

		if(file_exists($filename)) {
			require_once($filename);

			return new $class;
		}
	}

	return false;
}

function get_value($key = null, $default = null)
{
	$request = array_merge($_GET);

	if (empty($key)) {
		return $request;
	}

	if ($default != null) {
		$no_value = $default;
	}
	else
	{
		$no_value = false;
	}

	return isset($request[$key]) ? $request[$key] : $no_value;
}

function post_value($key = null, $default = null)
{
	$request = array_merge($_POST);

	if (empty($key)) {
		return $request;
	}

	if ($default != null) {
		$no_value = $default;
	}
	else
	{
		$no_value = false;
	}

	return isset($request[$key]) ? $request[$key] : $no_value;
}

function json_value($key = null, $default = null)
{
	$input = file_get_contents("php://input");

	$request = json_decode($input, true);

	if (empty($key)) {
		return $request;
	}

	if ($default != null) {
		$no_value = $default;
	}
	else
	{
		$no_value = false;
	}

	return isset($request[$key]) ? $request[$key] : $no_value;
}

function get_method()
{
	return $_SERVER['REQUEST_METHOD'];
}

function get_link($full = true)
{
	$server_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
	$uri = null;
	if ($full)
	{
		$uri = $_SERVER['REQUEST_URI'];
	}
	$actual_link = $server_protocol . "://$_SERVER[HTTP_HOST]" . $uri;

	return $actual_link;
}

if (!function_exists('startsWith'))
{
	function startsWith($haystack, $needle)
	{
		if (!empty($haystack) && !empty($needle))
		{
			return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
		}
		return false;
	}
}
