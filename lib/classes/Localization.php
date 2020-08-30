<?php

class Localization
{
	private static $langData = NULL;

	public static function init()
	{
		$lang = self::getLanguageData();
		self::$langData = $lang;
	}

	public static function translate($orig)
	{
		$lang_data = self::$langData;
		if (isset($lang_data[$orig]))
			return $lang_data[$orig];
		else
			return null;
	}

	public static function getLanguageData()
	{
		/*
		   TODO :
		   일단 Common만 사용할 것이므로
		   임시로 Cache 사용을 하지 않고
		   Common 내의 json을 불러온다.
		*/

		$locale = DEFAULT_LOCALE;
		$conf_path = PROJECT_ROOT . '/lang/common/' . $locale . '.json';
		$file = file_get_contents($conf_path, true);
		$json = json_decode($file, true);

		return $json;
	}
}

?>
