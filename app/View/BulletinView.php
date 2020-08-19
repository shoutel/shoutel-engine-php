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

		$bulletinModel = $this->loadModel('bulletin');
		$bulletinQuery = new BulletinQuery();

		$list = $bulletinModel->getBoardAllList();
		$count = $bulletinQuery->listAllCount();

		$pagination = $bulletinModel->getBoardListPagination($count);
		$page_buttons = $bulletinModel->getPaginationButton($pagination);

		$output = $this->render('bulletin/body', array(
			'posts' => $list,
			'pagination' => $page_buttons
		));

		return $output;
	}
	
	public function showList()
	{
		return '2332';
	}
}

?>
