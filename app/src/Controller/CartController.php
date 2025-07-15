<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PermissionException;
use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Exception\ProductNotFoundOrNotActiveException;
use App\Request\CartCreateRequest;
use App\Request\CartItemDeleteRequest;
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
        $cartItem = $cartItemService->create($user, $request->toDto());

        return $responder->respond($serializer->serialize($cartItem), Response::HTTP_CREATED);
    }

    #[Route(path: '/api/cart', name: 'cart_delete', methods: ['DELETE'])]
    public function deleteItem(
        #[CurrentUser] User $user,
        CartItemDeleteRequest $request,
        CartItemService $cartItemService,
    ): Response {
        try {
            $dto = $request->toDto();
            $cartItemService->checkUserCanDeleteCartItem($user, $dto->getCartItem());
            $cartItemService->delete($dto->getCartItem());
        } catch (EntityNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (PermissionException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(['message' => 'success']);
    }
}
