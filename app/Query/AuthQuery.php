<?php

class AuthQuery
{
    public function findMember($arr)
    {
        $query = 'select * from st_member where (
                  member_no = :no
                  or member_id = :member_id
                  or nick_name = :nick_name
                  ) limit 1';

        $db = new Database();

        $sth = $db->dbQuery($query, $arr, false);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetch(PDO::FETCH_OBJ);
    }

    public function findMemberByMemberNo($no)
    {
        $query = 'select * from st_member where ( member_no = :no ) LIMIT 1';

        $db = new Database();

        $arr = array(
            ':no' => $no
        );

        $sth = $db->dbQuery($query, $arr, false);

        if ($sth instanceof CreateError)
        {
            return $sth;
        }

        return $sth->fetch(PDO::FETCH_OBJ);
    }
}
