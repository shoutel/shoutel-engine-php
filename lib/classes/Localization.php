<?php

class Localization
{
	public $locale = DEFAULT_LOCALE;
	
	public function translate($orig)
	{
		/*
		   TODO :
		   일단 Common만 사용할 것이므로
		   임시로 Cache 사용을 하지 않고
		   Common 내의 json을 불러온다.
		*/
		
		
	}
	
	public function getLanguageData($dir)
	{
		
	}
}

?>
