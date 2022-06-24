<?php
namespace app\exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message="Route not found!", $code=0 , \Exception $previous=NULL)
    {
        $_SESSION['exceptionMessage'] = $message;
        parent::__construct($message, $code, $previous);
    }

}