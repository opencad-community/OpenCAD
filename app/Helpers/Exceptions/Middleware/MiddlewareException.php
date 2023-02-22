<?php

namespace Opencad\App\Helpers\Exceptions\Middleware;

use Opencad\App\Helpers\Exceptions\BaseException;

class MiddlewareException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}