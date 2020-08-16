<?php

use Mustache\mustache;

class BaseApp
{
	public $status = 'success';

	public $message = NULL;
	
	public $styleList = NULL;
	
	public $db = NULL;
	
	public function __construct()
	{
		$database = new Database();
		$this->db = $database->db;
	}

	public function invoke($param = array())
	{
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
		http_response_code($errorCode);

		$this->status = 'error';
		$this->message = $errorMessage;

		return;
	}

	public function render($tpl_path, $obj)
	{
		$f = file_get_contents(TEMPLATES_ROOT.$tpl_path.'.mustache', true);
		$m = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));
		$render = $m->render($f, $obj);
		
		return $render;
	}
}
