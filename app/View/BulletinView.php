<?php

class BulletinView extends BaseApp
{
	public $default_view = 'bulletin';

	public function bulletin()
	{
		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(false, 'js/menu.js', 3, 'body');

		$bulletinModel = $this->loadModel('bulletin');

		$board_id = get_value('boardId');
		$key = get_value('key');

		$bulletinModel->board_id = $board_id;

		$board_info = $bulletinModel->getBoardInfoByBoardId($board_id);

		if (!$board_info) return new NotFoundError();
		$list = $bulletinModel->getBoardArticleList();
		$pagination = $bulletinModel->getBulletinPagination();

		$output = $this->render('bulletin/comm_body', array(
			'posts' => $list,
			'pagination' => $pagination,
			'board_id' => $board_id,
			'key' => $key,
			'comm_info' => $board_info
		));

		return $output;
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
