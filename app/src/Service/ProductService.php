<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

readonly class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    /** @return Product[] */
    public function getActiveItems(int $limit = 20): array
    {
        return $this->productRepository->findBy(['is_active' => true], [], $limit);
    }
}
