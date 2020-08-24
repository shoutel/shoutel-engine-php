<?php

class CommunityView extends BaseApp
{
    public $default_view = 'index';

    public function index()
    {
        $bulletinView = $this->loadView('bulletin');
        return $bulletinView->commList();
    }
}
