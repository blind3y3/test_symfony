<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataKeeper\OrderStatus;
use App\Exception\CartWrongItemsCountException;
use App\Request\OrderCreateRequest;
use App\Responder\JsonResponder;
use App\Serializer\OrderSerializer;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OrderController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route(path: '/api/orders', name: 'orders_list', methods: ['GET'])]
    public function list(
        #[CurrentUser] $user,
        OrderService $orderService,
        OrderSerializer $serializer,
        JsonResponder $responder,
    ): Response {
        //@TODO status from Request
        $orders = $orderService->getListByUser($user, OrderStatus::PAID->value);

        return $responder->respond($serializer->serializeList($orders));
    }

    /**
     * @throws CartWrongItemsCountException
     * @throws ExceptionInterface
     */
    #[Route(path: '/api/orders', name: 'orders_create', methods: ['POST'])]
    public function create(
        #[CurrentUser] $user,
        OrderCreateRequest $request,
        OrderService $orderService,
        OrderSerializer $serializer,
        JsonResponder $responder,
    ): Response {
        $order = $orderService->create($user, $request->getDeliveryMethod());

        return $responder->respond($serializer->serialize($order), Response::HTTP_CREATED);
    }
}
