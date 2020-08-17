<?php

class FrontAssets
{
	static $styleList = NULL;

	static $jsList = NULL;

	static $bodyJsList = NULL;

	static $revision_data = NULL;

	public static function init()
	{
		self::$styleList = array();
		self::$jsList = array();
		self::$bodyJsList = array();
	}

	public static function load($css, $file = NULL, $pos = 0, $target = 'head')
	{
		$assetsDir = '/assets/';

		if ($css)
			$list = self::$styleList;
		elseif ($target == 'head')
			$list = self::$jsList;
		elseif ($target == 'body')
			$list = self::$bodyJsList;

		$already_exists = false;

		foreach ($list as $l)
		{
			if ($l['file'] == $file)
			{
				$already_exists = true;
				break;
			}
		}

		if ($already_exists == false)
		{
			$list[] = array(
				'pos' => $pos,
				'file' => $assetsDir . $file
			);

			uasort($list, function ($a, $b){
				return strnatcmp($a['pos'], $b['pos']);
			});

			if ($css)
				self::$styleList = $list;
			elseif ($target == 'head')
				self::$jsList = $list;
			elseif ($target == 'body')
				self::$bodyJsList = $list;
		}
	}

	public static function unload($file = NULL)
	{
		self::$styleList = 'sdfsdfsdf';
	}

	private static function getStyleList()
	{
		$obj = new stdClass();
		$obj->styleList = self::$styleList;
		$obj->jsList = self::$jsList;
		$obj->bodyJsList = self::$bodyJsList;

		return $obj;
	}

	public static function manageRevision($target)
	{
		if (!self::$revision_data)
		{
			$conf_path = DATA_ROOT . 'asset_revision.json';
			$file = file_get_contents($conf_path, true);

			$json = json_decode($file, true);

			self::$revision_data = $json;
		}
		else
		{
			$json = self::$revision_data;
		}

		$revision = $json['assetsRevision'];

		if (isset($revision))
		{
			return $revision[$target];
		}

		return;
	}

	public static function parseHtml()
	{
		$obj = self::getStyleList();

		$output = new stdClass();
		$output->css = $output->js = $output->body_js = '';

		$rev = self::manageRevision('css');
		foreach ($obj->styleList as $s)
		{
			
			$output->css .= '<link rel="stylesheet" href="' . $s['file'] . '?rev=' . $rev . '" type="text/css" />' . "\n    ";
		}

		$rev = self::manageRevision('js');
		foreach ($obj->jsList as $s)
		{
			$output->js .= '<script src="' . $s['file'] . '?rev=' . $rev . '"></script>' . "\n    ";
		}

		$rev = self::manageRevision('bodyJs');
		foreach ($obj->bodyJsList as $s)
		{
			$output->body_js .= '<script src="' . $s['file'] . '?rev=' . $rev . '"></script>' . "\n    ";
		}

		return $output;
	}
}

?>
