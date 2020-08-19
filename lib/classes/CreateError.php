<?php

class CreateError
{
    public $status = 'ok';

    public $message = NULL;
    
    public function __construct($statusCode = 0, $message = 'success')
	{
        if ($statusCode)
        {
            $this->status = 'error';
            $this->message = $message;
        }

        return;
    }
}

?>
