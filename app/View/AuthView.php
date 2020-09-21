<?php

class AuthView extends BaseApp
{
	public $default_view = 'login';

	public function login()
	{
		Display::setDisplayTitle('login');

		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/member/member.css', 1);
		$obj = new stdClass();
		return $this->render('auth/login', $obj);
	}

	public function join()
	{
		Display::setDisplayTitle('join');

		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/member/member.css', 1);
		FrontAssets::load(false, 'js/shoutel.util.js', 1, 'body');
		FrontAssets::load(false, 'js/join_agreement.js', 2, 'body');
		$obj = new stdClass();
		return $this->render('auth/join', $obj);
	}

	public function joinForm()
	{
		Display::setDisplayTitle('join');

		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/member/member.css', 1);
		FrontAssets::load(false, 'js/shoutel.util.js', 1, 'body');
		FrontAssets::load(false, 'js/join_form.js', 2, 'body');

		$obj = new stdClass();

		if (!CsrfToken::check())
		{
			$obj->message_header = Localization::translate('system_error');
			$obj->message = Localization::translate('invalid_csrf_token');

			return $this->render('auth/member_message', $obj);
		}

		if (!post_value('terms_agree') || !post_value('privacy_agree'))
		{
			$obj->message_header = Localization::translate('system_error');
			$obj->message = Localization::translate('agreement_not_passed');

			return $this->render('auth/member_message', $obj);
		}

		return $this->render('auth/join_form', $obj);
	}

	public function joinSuccess()
	{
		Display::setDisplayTitle('join');

		FrontAssets::load(true, '//cdn.shoutel.com/bulma/bulma.min.css', 1);
		FrontAssets::load(true, 'css/skin/member/member.css', 1);
		FrontAssets::load(false, 'js/shoutel.util.js', 1, 'body');

		$obj = new stdClass();

		$agreement_passed = Session::get('__JOIN_SUCCESS__');
		$msg = Session::get('__JOIN_SUCCESS_MSG__');

		if (!$agreement_passed) return new NotFoundError();

		Session::delete('__JOIN_SUCCESS__');
		Session::delete('__JOIN_SUCCESS_MSG__');

		$obj->message_header = 'join_success';
		$obj->message = $msg;

		return $this->render('auth/member_message', $obj);
	}
}

?>
