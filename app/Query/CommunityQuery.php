<?php

class CommunityQuery
{
	public function createCommunity($arr)
	{
		$query = 'INSERT INTO `st_board_list` (
				`board_id`, `board_name`, `board_admin`, `description`,
				`category`, `board_settings`, `register_date`
			) VALUES (
				?, ?, "2", ?, "0", ?, ?
			)';

		$db = new Database();

		$db->dbQuery($query, $arr, true);

		return true;
	}
}
