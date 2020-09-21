<?php

class AuthController extends BaseApp
{
	public function joinAgreement()
	{
		if (!CsrfToken::check())
		{
			return new CreateMsg(403, 'invalid_csrf_token');
		}

		$terms_agree = json_value('terms_agree');
		$privacy_agree = json_value('privacy_agree');

		if (!$terms_agree) return new CreateMsg(403, 'terms_not_agree');
		if (!$privacy_agree) return new CreateMsg(403, 'privacy_not_agree');

		$message = new CreateMsg(200, 'agree_ok');
		$set_session = Session::set('__JOIN_AGREEMENT__', true);

		if (!$set_session) return new CreateMsg(403, 'system_error');

		$obj = new stdClass();
		$obj->next_step = 'joinForm';
		$obj->terms_agree = $terms_agree;
		$obj->privacy_agree = $privacy_agree;

		$message->output = $obj;

		return $message;
	}

	public function join()
	{
		if (!CsrfToken::check())
		{
			return new CreateMsg(403, 'invalid_csrf_token');
		}

		$member_id = trim(json_value('member_id'));
		$password = trim(json_value('password'));
		$password_verify = trim(json_value('password_verify'));
		$email = trim(json_value('email'));
		$nick_name = trim(json_value('nick_name'));

		// no input
		if (!$member_id) return new CreateMsg(403, 'member_id_not_entered');
		if (!$password) return new CreateMsg(403, 'password_not_entered');
		if (!$password_verify) return new CreateMsg(403, 'password_verify_not_entered');
		if (!$email) return new CreateMsg(403, 'email_not_entered');
		if (!$nick_name) return new CreateMsg(403, 'nick_name_not_entered');

		// password_verify not match
		if ($password != $password_verify) return new CreateMsg(403, 'password_verify_not_match');

		// validation
		$member_id_len = mb_strlen($member_id, "UTF-8");
		$password_len = mb_strlen($password, "UTF-8");
		$email_len = mb_strlen($email, "UTF-8");
		$nick_name_len = mb_strlen($nick_name, "UTF-8");

		$validate_id = preg_match("/^[a-zA-Z0-9_]*$/", $member_id);
		$validate_email = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$validate_id) return new CreateMsg(403, 'member_id_not_valid');
		if (!$validate_email) return new CreateMsg(403, 'email_not_valid');

		if ($member_id_len > 30) return new CreateMsg(403, 'member_id_so_long');
		if ($password_len > 255) return new CreateMsg(403, 'password_so_long');
		if ($email_len > 255) return new CreateMsg(403, 'email_so_long');
		if ($nick_name_len > 48) return new CreateMsg(403, 'nick_name_so_long');

		$memberModel = $this->loadModel('member');
		$hash_password = $memberModel->getPasswordHash($password);

		$memberQuery = new MemberQuery();

		$arr = array(
			$member_id, $hash_password, $nick_name, $email
		);

		$memberQuery->insertMember($arr);

		$message = new CreateMsg(200, 'member_inserted');

		$obj = new stdClass();
		$obj->message = sprintf(Localization::translate('join_success_message'), $member_id);
		$obj->next_step = 'joinSuccess';

		$message->output = $obj;

		Session::set('__JOIN_SUCCESS__', true);
		Session::set('__JOIN_SUCCESS_MSG__', $obj->message);

		return $message;
	}
}
