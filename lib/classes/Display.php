<?php

use Minifier\TinyMinify;

class Display extends BaseApp
{
	public $no_template = FALSE;

	public $module = NULL;

	public $method = NULL;

	private $template_vars = NULL;
	
	protected $output = NULL;

	static $title = NULL;

	static $description = NULL;

	static $noindex = FALSE;
	
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

	public function getErrorMessage($no, $message, $statusCode = 500)
	{
		http_response_code($statusCode);

		$var = array(
			'msg_title' => 'Error',
			'err_in_code' => $no,
			'message' => $message
		);

		$var = array_merge($this->template_vars, $var);

		$output = $this->render('msg/defaultMessage', $var);

		return $output;
	}

	public function getDisplayDefaultHtml($content)
	{
		$assets = FrontAssets::parseHtml();
		$actual_link = get_link();
		$img_revision = FrontAssets::manageRevision('images');

		$var = array(
			'body_content' => $content,
			'css' => $assets->css,
			'js' => $assets->js,
			'body_js' => $assets->body_js,
			'curr_url' => $actual_link,
			'img_revision' => $img_revision,
			'site_description' => self::getDisplayDescription(),
			'robots_noindex' => self::getDisplayNoindex(),
			'title' => self::getDisplayTitle()
		);

		$var = array_merge($this->template_vars, $var);

		$content = $this->render('common/default_html', $var);

		return $content;
	}

	public static function setDisplayTitle($title)
	{
		self::$title = $title;
	}

	public static function getDisplayTitle()
	{
		$title = self::$title;
		$title_style = DEFAULT_TITLE_STYLE;

		if (!$title)
		{
			return SITE_NAME;
		}
		else
		{
			$title_style = str_replace('$TITLE', SITE_NAME, $title_style);
			$title_style = str_replace('$SUBTITLE', $title, $title_style);
			return $title_style;
		}
	}

	public static function setDisplayDescription($description)
	{
		self::$description = $description;
	}

	public static function getDisplayDescription()
	{
		if (!self::$description)
			return SITE_DESCRIPTION;
		else
			return self::$description;
	}

	public static function setDisplayNoindex($noindex)
	{
		self::$noindex = $noindex;
	}

	public static function getDisplayNoindex()
	{
		if (!self::$noindex)
			return;
		else
			return '<meta name="robots" content="noindex" />';
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
		FrontAssets::load(true, 'font-awesome/css/font-awesome.min.css', -1000000);

		$this->template_vars = array(
			'default_locale' => DEFAULT_LOCALE,
			'site_name' => SITE_NAME,
			'site_keywords' => SITE_KEYWORDS
		);

		if ($api == 'json')
		{
			$display = new JSONDisplay($module, $act);
			$display->init();
		}
		else
		{
			$display = new HTMLDisplay($module, $act);
			$display->init();
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
					$output = $this->getErrorMessage(500, $output->message);
				}
				
				if ($root)
				{
					$var = array(
						'content' => $output
					);

					$var = array_merge($this->template_vars, $var);

					$output = $this->render($root, $var);
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
