<?php

namespace app\exceptions;

class PageNotFoundException extends \Exception
{
    public function __construct($message="404, Page not found!", $code=0 , \Exception $previous=NULL)
    {
        $_SESSION['exceptionMessage'] = $message;
        parent::__construct($message, $code, $previous);
    }
}