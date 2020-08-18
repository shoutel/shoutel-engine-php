<?php

class BulletinView extends BaseApp
{
	public $default_view = 'index';
	
	public function index()
	{
		FrontAssets::load(true, 'css/skin/default/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/home.css', 2);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(false, 'js/menu.js', 3, 'body');

		return 'sdfsdf';
	}
	
	public function showList()
	{
		return '2332';
	}
}

?>
