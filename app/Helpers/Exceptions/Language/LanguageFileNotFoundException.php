<?php

namespace Opencad\App\Helpers\Exceptions\Language;

use Opencad\App\Helpers\Exceptions\BaseException;

class LanguageFileNotFoundException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
