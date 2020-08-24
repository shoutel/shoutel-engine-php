<?php

class BulletinQuery
{
    public function listAllCount()
    {
        $query = 'select count(*) from st_board';

        $db = new Database();

        $sth = $db->dbQuery($query);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetchColumn();
    }

    public function listAllCountByBoardId($board_id)
    {
        $query = 'select count(*) from st_board where board_id = ?';

        $db = new Database();

        $arr = array($board_id);

        $sth = $db->dbQuery($query, $arr);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetchColumn();
    }

    public function findBoard($arr)
    {
        $query = 'select * from st_board_list where (
                  no = :no
                  or board_id = :board_id
                  or board_name = :board_name
                  ) limit 1';

        $db = new Database();

        $sth = $db->dbQuery($query, $arr, false);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetch(PDO::FETCH_OBJ);
    }

    public function boardAllList($arr)
    {
        $query = 'select * from st_board order by no desc limit :before, :list_count';

        $db = new Database();
        $sth = $db->dbQuery($query, $arr, false);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetchAll();
    }

    public function boardList($arr)
    {
        $query = 'select * from st_board_list order by no desc limit :before, :list_count';

        $db = new Database();
        $sth = $db->dbQuery($query, $arr, false);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetchAll();
    }

    public function listBoardListCount()
    {
        $query = 'select count(*) from st_board_list';

        $db = new Database();

        $sth = $db->dbQuery($query);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetchColumn();
    }
}
