<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Product;

class ProductFactory
{
    public function create(): Product
    {
        $product = new Product();
        $product->setIsActive(true);

        return $product;
    }
}
