<?php

class MemberModel extends BaseApp
{
    public function getAccountInfo($no)
    {
        $memberQuery = new MemberQuery();

        return $memberQuery->findMemberByMemberNo($no);
    }

    public function findAccount($obj)
    {
        $memberQuery = new MemberQuery();

        $member_no = isset($obj->member_no) ? $obj->member_no : NULL;
        $member_id = isset($obj->member_id) ? $obj->member_id : NULL;
		$nick_name = isset($obj->nick_name) ? $obj->nick_name : NULL;
		$email = isset($obj->email) ? $obj->email : NULL;

        $arr = array(
			':no' => $member_no,
			':member_id' => $member_id,
			':nick_name' => $nick_name,
			':email' => $email
        );

        return $memberQuery->findMember($arr);
	}

	public function getPasswordHash($pass)
	{
		$options = [
			'cost' => 12,
		];
		return password_hash($pass, PASSWORD_BCRYPT, $options);
	}
}

?>
