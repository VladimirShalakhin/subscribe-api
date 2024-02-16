<?php

namespace App\Exceptions;

use Exception;

class EmailSendException extends Exception
{
    public const ERROR_CODE = 400;

    public const ERROR_MESSAGE = 'Возникла ошибка при отправку подтверждения регистрации на указанную почту';

    public function __construct()
    {
        $this->code = static::ERROR_CODE;
        $this->message = static::ERROR_MESSAGE;
        parent::__construct($this->message, $this->code);
    }
}
