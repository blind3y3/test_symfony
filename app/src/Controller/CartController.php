<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Exception\ProductNotFoundOrNotActiveException;
use App\Request\CartCreateRequest;
use App\Responder\JsonResponder;
use App\Serializer\CartItemSerializer;
use App\Service\CartItemService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class CartController
{
    /**
     * @throws ExceptionInterface
     * @throws ProductNotFoundOrNotActiveException
     */
    #[Route(path: '/api/cart', name: 'cart_add', methods: ['POST'])]
    public function addItem(
        #[CurrentUser] User $user,
        CartCreateRequest $request,
        JsonResponder $responder,
        CartItemService $cartItemService,
        CartItemSerializer $serializer,
    ): Response {
        try {
            $cartItem = $cartItemService->create($user, $request->toDto());
        } catch (EntityNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $responder->respond($serializer->serialize($cartItem), Response::HTTP_CREATED);
    }
}
