<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeliveryController
{
    #[Route(path: '/api/delivery-methods', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse(Order::getDeliveryMethods());
    }
}
