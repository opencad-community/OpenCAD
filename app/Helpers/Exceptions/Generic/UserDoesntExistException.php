<?php

namespace Opencad\App\Helpers\Exceptions\Generic;

use Opencad\App\Helpers\Exceptions\BaseException;

class UserDoesntExistException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
