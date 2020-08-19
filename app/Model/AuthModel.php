<?php

class AuthModel extends BaseApp
{
    public function getAccountInfo($no)
    {
        $authQuery = new AuthQuery();

        return $authQuery->findMemberByMemberNo($no);
    }

    public function findAccount($obj)
    {
        $authQuery = new AuthQuery();

        $member_no = isset($obj->member_no) ? $obj->member_no : NULL;
        $member_id = isset($obj->member_id) ? $obj->member_id : NULL;
        $nick_name = isset($obj->nick_name) ? $obj->nick_name : NULL;

        $arr = array(
			':no' => $member_no,
			':member_id' => $member_id,
			':nick_name' => $nick_name
        );

        return $authQuery->findMember($arr);
    }
}

?>
