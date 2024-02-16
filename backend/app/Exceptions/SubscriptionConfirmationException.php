<?php

namespace App\Exceptions;

use Exception;

class SubscriptionConfirmationException extends Exception
{
    public const ERROR_CODE = 400;

    public const ERROR_MESSAGE = 'Ошибка подтверждения подписки';

    public function __construct()
    {
        $this->code = static::ERROR_CODE;
        $this->message = static::ERROR_MESSAGE;
        parent::__construct($this->message, $this->code);
    }
}
