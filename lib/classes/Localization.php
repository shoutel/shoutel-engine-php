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
			return $orig;
	}

	public static function getLanguageData()
	{
		$locale = DEFAULT_LOCALE;
		$conf_path = PROJECT_ROOT . '/lang/common/' . $locale . '.json';
		$file = file_get_contents($conf_path, true);
		$json = json_decode($file, true);

		return $json;
	}
}

?>
