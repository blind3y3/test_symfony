<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\CartItem;

readonly class CartItemDeleteDto
{
    public function __construct(private CartItem $cartItem)
    {
    }

    public function getCartItem(): CartItem
    {
        return $this->cartItem;
    }
}
