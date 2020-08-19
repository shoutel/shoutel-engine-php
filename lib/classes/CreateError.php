<?php

class CreateError
{
    public $status = 'ok';

    public $statusCode = 500;

    public $message = NULL;
    
    public function __construct($statusCode = 0, $message = 'success')
	{
        if ($statusCode)
        {
            $this->statusCode = $statusCode;
            $this->status = 'error';
            $this->message = $message;
        }

        return;
    }
}

?>
