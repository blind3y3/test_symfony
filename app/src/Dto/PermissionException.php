<?php

declare(strict_types=1);

namespace App\Dto;

use Exception;
use Throwable;

class PermissionException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("You don't have permission for this action", $code, $previous);
    }
}
