<?php

class BulletinModel extends BaseApp
{
    private $list_count = NULL;

    private $count = NULL;

    private $page = NULL;

    public function getBoardInfoByBoardId($board_id)
    {
        $bulletinQuery = new BulletinQuery();

        $arr = array(
			':no' => NULL,
			':board_id' => $board_id,
			':board_name' => NULL
        );

        return $bulletinQuery->findBoard($arr);
    }

    public function getBulletinPagination()
    {
        $paginationModel = $this->loadModel('pagination');

        $paginationModel->list_count = $this->list_count;
        $paginationModel->page = $this->page;
        $paginationModel->count = $this->count;

        $pagination = $paginationModel->getPagination();
        $page_buttons = $paginationModel->getPaginationButton($pagination);

        return $page_buttons;
    }

    public function getBoardAllList()
    {
        $page = get_value('page');

		if (!$page)
			$page = 1;

        $list_count = 30;
        $this->page = $page;
        $this->list_count = $list_count;
        $before = $list_count * ($page - 1);

        $bulletinQuery = new BulletinQuery();

        $count = $bulletinQuery->listAllCount();
        $this->count = $count;

        $arr = array(
			':before' => (int)$before,
			':list_count' => (int)$list_count
		);

        $list = $bulletinQuery->boardAllList($arr);

        $arr = array();

        foreach ($list as $i)
        {
            $item = $this->getBoardItem($i);
            array_push($arr, $item);
        }

        return $arr;
    }

    public function getBoardAllListPagination()
    {
        $paginationModel = $this->loadModel('pagination');

        $paginationModel->list_count = $this->list_count;
        $paginationModel->page = $this->page;
        $paginationModel->count = $this->count;

        $pagination = $paginationModel->getPagination();
        $page_buttons = $paginationModel->getPaginationButton($pagination);

        return $page_buttons;
    }

    public function getBoardItem($item)
    {
        $obj = new stdClass();

        // set default value
        $obj->no = $item['no'];
        $obj->key = $item['key'];
        $obj->board_id = $item['board_id'];
        $obj->title = $item['title'];
        $obj->content = $item['content'];
        $obj->register_date = $item['register_date'];
        $obj->edit_date = $item['edit_date'];
        $obj->member_no = $item['member_no'];
        $obj->hit = $item['hit'];
        $obj->vote_up = $item['vote_up'];
        $obj->vote_down = $item['vote_down'];

        // additional info
        $authModel = $this->loadModel('auth');
        $member_no = $obj->member_no;
        $account_info = $authModel->getAccountInfo($member_no);
        $obj->nick_name = $account_info->nick_name;

        $board_id = $obj->board_id;
        $board_info = $this->getBoardInfoByBoardId($board_id);
        $obj->board_name = $board_info->board_name;

        return $obj;
    }

    /**
     * get board (community) list
     */
    public function getBoardList()
    {
        $page = get_value('page');

		if (!$page)
			$page = 1;

        $list_count = 30;
        $this->page = $page;
        $this->list_count = $list_count;
        $before = $list_count * ($page - 1);

        $bulletinQuery = new BulletinQuery();

        $count = $bulletinQuery->listBoardListCount();
        $this->count = $count;

        $arr = array(
			':before' => (int)$before,
			':list_count' => (int)$list_count
		);

        $list = $bulletinQuery->boardList($arr);

        $arr = array();

        foreach ($list as $i)
        {
            $item = $this->getBoardListItem($i);
            array_push($arr, $item);
        }

        return $arr;
    }

    public function getBoardListItem($item)
    {
        $obj = new stdClass();

        // set default value
        $obj->no = $item['no'];
        $obj->board_id = $item['board_id'];
        $obj->board_name = $item['board_name'];
        $obj->board_admin = $item['board_admin'];
        $obj->description = $item['description'];
        $obj->category = $item['category'];
        $obj->board_cover = $item['board_cover'];
        $obj->register_date = $item['register_date'];

        // additional info
        $authModel = $this->loadModel('auth');
        $member_no = $obj->board_admin;
        $account_info = $authModel->getAccountInfo($member_no);
        $obj->nick_name = $account_info->nick_name;

        $managers = $item['board_managers'];
        $obj->board_managers = array();
        if ($managers)
        {
            $managers = json_decode($managers);
            $obj->board_managers = $managers->boardManagers;
        }

        $obj->settings = json_decode($item['board_settings']);

        return $obj;
    }
}
