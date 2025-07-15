<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CartItemAddDto;
use App\Dto\PermissionException;
use App\Entity\CartItem;
use App\Entity\User;
use App\Repository\CartItemRepository;

readonly class CartItemService
{
    public function __construct(
        private CartItemRepository $cartItemRepository,
    ) {
    }

    public function create(User $user, CartItemAddDto $dto): CartItem
    {
        return $this->cartItemRepository->create($user, $dto->getProduct(), $dto->getQuantity());
    }

    /**
     * @throws PermissionException
     */
    public function checkUserCanDeleteCartItem(User $user, CartItem $cartItem): void
    {
        $isUserHaveAccess = $this->cartItemRepository->isUserHaveAccess($user, $cartItem);
        if (!$isUserHaveAccess) {
            throw new PermissionException();
        }
    }

    public function delete(CartItem $cartItem): void
    {
        $this->cartItemRepository->delete($cartItem);
    }
}
