<?php

class AuthView extends BaseApp
{
	public $default_view = 'login';
	
	public function login()
	{
		$db = $this->db;

		FrontAssets::load(true, 'dsfsdf33.css', 3);
		FrontAssets::load(true, 'dsfsdf334.css', 2);
		FrontAssets::load(false, 'headjs.js', 3, 'head');
		FrontAssets::load(false, 'bodyjs.js', 2, 'body');
		$obj = new stdClass();
		$obj->lang_id = 'Id';
		$obj->lang_pass = '패스워드';
		return $this->render('auth/login', $obj);
	}
}

?>
