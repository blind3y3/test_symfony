<?php

declare(strict_types=1);

namespace App\Exception;

class ProductNotFoundOrNotActiveException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Product not found or not active', $code, $previous);
    }
}
