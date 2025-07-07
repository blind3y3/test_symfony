<?php

declare(strict_types=1);

namespace App\Exception;

class PickedProductException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('One or more picked products have been inactive', $code, $previous);
    }
}
