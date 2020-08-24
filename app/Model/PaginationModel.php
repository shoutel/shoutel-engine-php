<?php

class PaginationModel extends BaseApp
{
    public $list_count = NULL;

    public $page = NULL;

    public $count = NULL;

    public $one_section = 10;

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

    public function getPagination()
    {
        $list_count = $this->list_count;
        $page = $this->page;
        $count = $this->count;

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
}
