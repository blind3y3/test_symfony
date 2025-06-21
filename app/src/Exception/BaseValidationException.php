<?php

declare(strict_types=1);

namespace App\Exception;

class BaseValidationException extends \Exception
{
    public array $errors = [];

    public function __construct(string $message = '', array $errors = [], int $code = 0, ?\Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }
}
