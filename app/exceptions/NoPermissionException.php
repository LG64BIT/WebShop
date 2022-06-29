<?php

namespace App\exceptions;

use Exception;

class NoPermissionException extends Exception
{
    public function __construct($message="Permission needed for that action", $code=0 , Exception $previous=NULL)
    {
        $_SESSION['exceptionMessage'] = $message;
        parent::__construct($message, $code, $previous);
    }
}
