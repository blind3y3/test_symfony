<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Exception\BaseValidationException;
use App\Exception\EntityNotFoundException;
use App\Responder\CartItemJsonResponder;
use App\Service\CartItemService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class CartController
{
    /**
     * @throws ExceptionInterface
     * @throws BaseValidationException
     * @throws EntityNotFoundException
     */
    #[Route(path: '/api/cart', name: 'cart_add', methods: ['POST'])]
    public function addItem(
        #[CurrentUser] User $user,
        Request $request,
        CartItemJsonResponder $responder,
        CartItemService $cartItemService,
    ): Response {
        $productId = $request->getPayload()->get('productId');
        $quantity = $request->getPayload()->get('quantity');
        $cartItem = $cartItemService->create($user, $productId, $quantity);

        return $responder->respond($cartItem, Response::HTTP_CREATED);
    }
}
