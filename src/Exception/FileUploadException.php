<?php

namespace App\Exception;

use Exception;

class FileUploadException extends Exception
{

    public function __construct(
        protected $message = 'File upload error',
        protected $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
