<?php

class CommunityController extends BaseApp
{
	public function createCommunity()
	{
		if (!CsrfToken::check())
		{
			return new CreateMsg(403, 'invalid_csrf_token');
		}

		$comm_name = trim(json_value('comm_name'));
		$comm_id = trim(json_value('comm_id'));
		$description = trim(json_value('description'));

		// no input
		if (!$comm_name) return new CreateMsg(403, 'comm_name_not_entered');
		if (!$comm_id) return new CreateMsg(403, 'comm_id_not_entered');
		if (!$description) return new CreateMsg(403, 'description_not_entered');

		// validation
		$comm_name_len = mb_strlen($comm_name, "UTF-8");
		$comm_id_len = mb_strlen($comm_id, "UTF-8");
		$description_len = mb_strlen($description, "UTF-8");

		$validate_id = preg_match("/^[a-zA-Z0-9_]*$/", $comm_id);

		if ($comm_name_len > 20) return new CreateMsg(403, 'comm_name_so_long');
		if ($comm_id_len > 64) return new CreateMsg(403, 'comm_id_so_long');
		if ($description_len > 1000) return new CreateMsg(403, 'description_so_long');

		if (!$validate_id) return new CreateMsg(403, 'comm_id_not_valid');

		$bulletinModel = $this->loadModel('bulletin');
		$board_info = $bulletinModel->getBoardInfoByBoardId($comm_id);
		if ($board_info) return new CreateMsg(403, 'board_already_exists');

		$settings = '{"permission":{"list":1,"view":1,"writePost":1,"writeComment":1,"vote":2}}';
		$date = date("Y-m-d H:i:s");

		$communityQuery = new CommunityQuery();

		$arr = array(
			$comm_id, $comm_name, $description, $settings, $date
		);

		$communityQuery->createCommunity($arr);

		$message = new CreateMsg(200, 'community_inserted');

		$obj = new stdClass();
		$obj->comm_id = $comm_id;

		$message->output = $obj;

		return $message;
	}

	public function _jsonApiIndex()
	{
		switch(get_method())
		{
			case 'PUT':
				return $this->createCommunity();
			break;
			case 'POST':
				return new CreateMsg(404, 'not_found');
			break;
		}
	}
}
