<?php
namespace app\exceptions;

class MethodNotAllowedException extends \Exception
{
    public function __construct($message="Method not allowed!", $code=0 , \Exception $previous=NULL)
    {
        $_SESSION['exceptionMessage'] = $message;
        parent::__construct($message, $code, $previous);
    }

}