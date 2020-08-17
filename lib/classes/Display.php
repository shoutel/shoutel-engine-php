<?php

use Minifier\TinyMinify;

class Display extends BaseApp
{
	public $no_template = FALSE;

	public $module = NULL;

	public $method = NULL;
	
	protected $output = NULL;
	
	public function getDisplayRootTemplate($obj)
	{
		$module = $obj->module;
		$method = $obj->method;
		
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

	public function getDisplayDefaultHtml($content)
	{
		$assets = FrontAssets::parseHtml();
		$actual_link = get_link();
		$img_revision = FrontAssets::manageRevision('images');

		$content = $this->render('common/default_html', array(
			'body_content' => $content,
			'css' => $assets->css,
			'js' => $assets->js,
			'body_js' => $assets->body_js,
			'canonical_url' => DEFAULT_URL,
			'curr_url' => $actual_link,
			'img_revision' => $img_revision
		));

		return $content;
	}
	
	public function displayAction($param, $actionKey = ['module', 'action', 'api'])
	{
		$module_key = $actionKey[0];
		$act_key = $actionKey[1];
		$api_key = $actionKey[2];
		
		$module = get_value($module_key);
		$act = get_value($act_key);
		$api = get_value($api_key);

		FrontAssets::init();

		// include common CSS
		FrontAssets::load(true, 'css/common/common.css', -1000000);

		if ($api == 'json')
		{
			$display = new JSONDisplay($module, $act);
		}
		else
		{
			$display = new HTMLDisplay($module, $act);
		}

		if (isset($display))
		{
			$output = $display->output;

			$obj = new stdClass();
			$obj->module = $display->module;
			$obj->method = $display->method;
			
			if (!$display->no_template)
			{
				$root = $this->getDisplayRootTemplate($obj);

				if ($output instanceof CreateError)
				{
					$output = $this->render('msg/defaultMessage', array(
						'msg_title' => 'Error',
						'message' => $output->message
					));
				}
				
				if ($root)
				{
					$output = $this->render($root, array(
						'content' => $output
					));
				}

				$output = $this->getDisplayDefaultHtml($output);
			}
			else
			{
				$obj = new stdClass();
			
				if ($output instanceof CreateError)
				{
					$obj->status = $output->status;
					$obj->message = $output->message;
				}
				else
				{
					$obj->output = $output;
				}
				
				$output = json_encode($obj);
			}
			
			print $output;
			exit();
		}
	}
}

?>
