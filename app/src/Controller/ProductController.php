<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Responder\JsonResponder;
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
        ProductRepository $productRepository,
        JsonResponder $responder,
    ): Response {
        // @TODO стоит ли выносить в сервис?
        $products = $productRepository->get();

        return $responder->respond($products);
    }
}
