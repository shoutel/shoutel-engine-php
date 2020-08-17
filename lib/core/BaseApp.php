<?php

use Mustache\mustache;

class BaseApp
{
	public $db = NULL;
	
	public function __construct()
	{
		$database = new Database();
		$this->db = $database;
	}

	public function invoke($param = array())
	{
		if (get_link(false) != DEFAULT_URL)
		{
			$uri = $_SERVER['REQUEST_URI'];
			$this->redirect(DEFAULT_URL . $uri);
		}

		$display = new Display();
		$display->displayAction($param);
	}
	
	public function loadModel($name)
	{
		$class_name = ucfirst(strtolower($name)) . 'Model';

		$class = load_class($class_name);
		
		if ($class) return $class;
	}

	public function loadView($name)
	{
		$class_name = ucfirst(strtolower($name)) . 'View';

		$class = load_class($class_name);
		
		if ($class) return $class;
	}

	public function loadController($name)
	{
		$class_name = ucfirst(strtolower($name)) . 'Controller';

		$class = load_class($class_name);
		
		if ($class) return $class;
	}

	public function redirect($target)
	{
		header("Location: {$target}");

		exit;
	}
  
	public function showError($errorCode, $errorMessage = 'ok')
	{
		
	}

	public function render($tpl_path, $obj)
	{
		$f = file_get_contents(TEMPLATES_ROOT.$tpl_path.'.mustache', true);
		$m = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));
		$render = $m->render($f, $obj);
		
		return $render;
	}
}
