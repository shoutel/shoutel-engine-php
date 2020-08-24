<?php

class HomeView extends BaseApp
{
	public $default_view = 'index';
	
	public function index()
	{
		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/home.css', 2);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(false, 'js/menu.js', 3, 'body');

		$bulletinModel = $this->loadModel('bulletin');

		$list = $bulletinModel->getBoardAllList();
		$pagination = $bulletinModel->getBulletinPagination();

		$output = $this->render('bulletin/home', array(
			'posts' => $list,
			'pagination' => $pagination
		));

		return $output;
	}
}
