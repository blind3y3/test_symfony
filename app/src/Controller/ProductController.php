<?php

declare(strict_types=1);

namespace App\Controller;

use App\Responder\JsonResponder;
use App\Serializer\ProductSerializer;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ProductController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route(path: '/api/products', name: 'products_list', methods: ['GET'])]
    public function list(
        ProductService $productService,
        JsonResponder $responder,
        ProductSerializer $serializer,
    ): Response {
        $products = $productService->getActiveItems();

        return $responder->respond($serializer->serializeList($products));
    }
}
