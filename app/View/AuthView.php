<?php

class AuthView extends BaseApp
{
	public $default_view = 'login';
	
	public function login()
	{
		Display::setDisplayTitle('Auth');

		FrontAssets::load(false, 'headjs.js', 3, 'head');
		$obj = new stdClass();
		$obj->lang_id = 'Id';
		$obj->lang_pass = '패스워드';
		return $this->render('auth/login', $obj);
	}
}

?>
