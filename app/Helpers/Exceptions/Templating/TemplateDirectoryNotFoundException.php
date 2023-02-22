<?php

namespace Opencad\App\Helpers\Exceptions\Templating;

use Opencad\App\Helpers\Exceptions\BaseException;

class TemplateDirectoryNotFoundException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
