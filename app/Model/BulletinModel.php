<?php

class BulletinModel extends BaseApp
{
    public $list_count = NULL;

    public $page = NULL;

    public $one_section = 10;

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

    public function getPaginationButton($pagination)
    {
        $output = array();

        foreach ($pagination as $p)
		{
			$obj = new stdClass();
			$obj->page = $p->page;
			switch ($p->type)
			{
				case 'onePage':
					$obj->button = '&lt;&lt;';
					break;
				case 'prevPage':
					$obj->button = '&lt;';
					break;
				case 'currentPage':
				case 'page':
					$obj->button = $obj->page;
					break;
				case 'nextPage':
					$obj->button = '&gt;';
					break;
				case 'endPage':
					$obj->button = '&gt;&gt;';
					break;
			}

			array_push($output, $obj);
        }

        return $output;
    }

    public function getBoardListPagination($count)
    {
        $list_count = $this->list_count;
        $page = $this->page;

        $total_page = ceil($count / $list_count);

        if($page < 1 || ($total_page && $page > $total_page)) {
            return array();
        }

        $one_section = $this->one_section;
        $current_section = ceil($page / $one_section);
        $all_section = ceil($total_page / $one_section);

        $first_page = ($current_section * $one_section) - ($one_section - 1);

        $last_page = $current_section * $one_section;

        if ($current_section == $all_section)
            $last_page = $total_page;

        $prev_page = (($current_section - 1) * $one_section);
        $next_page = (($current_section + 1) * $one_section) - ($one_section - 1);
        
        $output = array();
        if ($page != 1)
        {
            $pagination = new stdClass();
            $pagination->type = 'onePage';
            $pagination->page = 1;

            array_push($output, $pagination);
        }

        if ($current_section != 1)
        {
            $pagination = new stdClass();
            $pagination->type = 'prevPage';
            $pagination->page = $prev_page;

            array_push($output, $pagination);
        }

        for ($i = $first_page; $i <= $last_page; $i++)
        {
            if ($i == $page)
            {
                $pagination = new stdClass();
                $pagination->type = 'currentPage';
                $pagination->page = $i;

                array_push($output, $pagination);
            }
            else
            {
                $pagination = new stdClass();
                $pagination->type = 'page';
                $pagination->page = $i;

                array_push($output, $pagination);
            }
        }

        if ($current_section != $all_section)
        {
            $pagination = new stdClass();
            $pagination->type = 'nextPage';
            $pagination->page = $next_page;

            array_push($output, $pagination);
        }

        if ($page != $total_page)
        {
            $pagination = new stdClass();
            $pagination->type = 'endPage';
            $pagination->page = $total_page;

            array_push($output, $pagination);
        }

        return $output;
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
}
