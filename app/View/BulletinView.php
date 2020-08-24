<?php

class BulletinView extends BaseApp
{
	public $default_view = 'bulletin';

	public function bulletin()
	{
		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(false, 'js/menu.js', 3, 'body');

		return '2332';
	}

	public function commList()
	{
		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(true, 'css/skin/default/card.css', 3);
		FrontAssets::load(false, 'js/menu.js', 3, 'body');

		$bulletinModel = $this->loadModel('bulletin');

		$list = $bulletinModel->getBoardList();
		$pagination = $bulletinModel->getBulletinPagination();

		$output = $this->render('community/list', array(
			'comm_list' => $list,
			'pagination' => $pagination
		));

		return $output;
	}
}

?>
