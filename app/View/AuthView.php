<?php

class AuthView extends BaseApp
{
	public $default_view = 'login';
	
	public function login()
	{
		$obj = new stdClass();
		$obj->lang_id = '아이디';
		$obj->lang_pass = '패스워드';
		return $this->render('auth/login', $obj);
	}
}

?>
