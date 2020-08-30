<?php

class CreateMsg
{
    public $status = 'ok';

    public $statusCode = 500;

	public $message = NULL;

	public $output = NULL;

    public function __construct($statusCode = 0, $message = 'success')
	{
        if ($statusCode)
        {
			$this->statusCode = $statusCode;
			if ($statusCode != 200) $this->status = 'error';

			$translate = Localization::translate($message);
			if ($translate)
				$this->message = $translate;
			else
				$this->message = $message;
        }

        return;
    }
}

?>
