<?php

declare(strict_types=1);

namespace App\Exception;

class UserAlreadyExistsException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('User with this credentials already exists', $code, $previous);
    }
}
