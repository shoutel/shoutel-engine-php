<?php

use Mustache\mustache;

class BaseApp
{
	public function invoke($param = array())
	{
		if (get_link(false) != DEFAULT_URL)
		{
			$uri = $_SERVER['REQUEST_URI'];
			$this->redirect(DEFAULT_URL . $uri);
		}

		Session::start();
		Database::init();

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
		$mustache = new Mustache_Engine(array(
			'entity_flags' => ENT_QUOTES,
			'cache' => DATA_ROOT . 'cache/templates',
			'cache_file_mode' => 0600,
			'cache_lambda_templates' => true,
			'loader' => new Mustache_Loader_FilesystemLoader(TEMPLATES_ROOT),
			'partials_loader' => new Mustache_Loader_FilesystemLoader(TEMPLATES_ROOT . 'partials'),
			'escape' => function($value) {
				return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
			},
			'charset' => 'UTF-8',
			'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
			'strict_callables' => true,
			'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
		));
		$m = $mustache->loadTemplate($tpl_path);
		$render = $m->render($obj);

		return $render;
	}
}
