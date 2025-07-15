<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Product;

readonly class CartItemAddDto
{
    public function __construct(
        private Product $product,
        private int $quantity,
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
