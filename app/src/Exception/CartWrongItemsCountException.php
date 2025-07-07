<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class CartWrongItemsCountException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Cart Items count should be between 1 and 20', $code, $previous);
    }
}
