<?php
namespace App\exceptions;

use Exception;

class FileUploadException extends Exception
{
    public function __construct($message="File upload problems", $code=0 , Exception $previous=NULL)
    {
        $_SESSION['exceptionMessage'] = $message;
        parent::__construct($message, $code, $previous);
    }
}
