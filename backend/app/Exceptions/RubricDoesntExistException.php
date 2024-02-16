<?php

namespace App\Exceptions;

use Exception;

class RubricDoesntExistException extends Exception
{
    public const ERROR_CODE = 400;

    public const ERROR_MESSAGE = 'Указанные рубрики отсутствуют в системе';

    public function __construct()
    {
        $this->code = static::ERROR_CODE;
        $this->message = static::ERROR_MESSAGE;
        parent::__construct($this->message, $this->code);
    }
}
