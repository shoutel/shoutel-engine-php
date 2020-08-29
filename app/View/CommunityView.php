<?php

class CommunityView extends BaseApp
{
    public $default_view = 'index';

    public function index()
    {
        $bulletinView = $this->loadView('bulletin');
        return $bulletinView->commList();
	}

	public function create()
	{
		Display::setDisplayTitle('커뮤니티 생성');
		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/default/forum.css', 3);
		FrontAssets::load(true, 'css/skin/default/create.css', 3);
		FrontAssets::load(false, 'js/create_community.js', 1, 'body');

		$output = $this->render('community/create', array(

		));

		return $output;
	}
}
