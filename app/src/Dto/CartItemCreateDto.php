<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Product;
use App\Entity\User;

readonly class CartItemCreateDto
{
    public function __construct(
        private User $user,
        private Product $product,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
