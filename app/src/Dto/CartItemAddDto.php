<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CartItemAddDto
{
    public function __construct(
        private int $productId,
        private int $quantity,
    ) {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
