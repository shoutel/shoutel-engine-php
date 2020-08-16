<?php

use Minifier\TinyMinify;

class Display extends BaseApp
{
	protected $module = FALSE;

	protected $method = FALSE;
	
	protected $no_template = FALSE;
	
	protected $output = FALSE;
	
	public function getDisplayRootTemplate()
	{
		$module = $this->module;
		$method = $this->method;
		
		if ($module && $method)
		{
			$conf_path = VIEW_ROOT . 'templates.json';
			$file = file_get_contents($conf_path, true);
			$json = json_decode($file, true);

			$view = ucfirst(strtolower($module)) . 'View';
			
			if (isset($json[$view]))
			{
				foreach ($json[$view] as $m)
				{
					$template = $m['template'];
					$views = $m['views'];

					foreach ($views as $v)
					{
						if ($v == $method)
						{
							return $template;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	public function displayAction($param, $actionKey = ['module', 'action', 'api'])
	{
		$module_key = $actionKey[0];
		$act_key = $actionKey[1];
		$api_key = $actionKey[2];
		
		$module = get_value($module_key);
		$act = get_value($act_key);
		$api = get_value($api_key);
		
		if ($api == 'json')
		{
			$this->no_template = true;

			if ($module && $act)
			{
				$class = $this->loadController($module);

				if ($class)
				{
					$method = $act;

					if (!method_exists($class, $method)) {
						$this->showError(404, 'method_not_found');
					}
					else
					{
						$output = $class->$method($param);
						
						$this->output = $output;
					}
				}
				else
				{
					$this->showError(404, 'class_not_found');
				}
			}
		}
		else
		{
			if (($module && !$act) ||
				($module && $act))
			{
				$class = $this->loadView($module);

				if ($class)
				{
					$default_view = $class->default_view;
					$method = $act ? $act : $default_view;
					
					if (!method_exists($class, $method)) {
						$method = $default_view;
					}
				}
				else
				{
					$this->showError(404, 'class_not_found');
				}
			}
			else
			{
				$module = DEFAULT_CLASS;
				$class = $this->loadView($module);
				$method = DEFAULT_HOME;
			}
			
			if (isset($method))
			{
				$this->module = $module;
				$this->method = $method;
				
				$content = $class->$method($param);
			}
		}
		
		if (!$this->no_template)
		{
			if ($this->status == 'error' && $this->message)
			{
				$content = $this->render('msg/defaultMessage', array(
					'msg_title' => 'Error',
					'message' => $this->message
				));
			}
			else
			{
				$root = $this->getDisplayRootTemplate();
				
				if ($root)
				{
					$content = $this->render($root, array(
						'content' => $content
					));
				}
			}
			
			$css = $js = '';
			$content = $this->render('common/default_html', array(
				'body_content' => $content,
				'css' => $css,
				'js' => $js
			));
		}
		else
		{
			$obj = new stdClass();
			
			$obj->status = $this->status;
			$obj->message = $this->message;
			$obj->output = $output;
			
			$content = json_encode($obj);
		}
		
		print $content;
	}
}

?>