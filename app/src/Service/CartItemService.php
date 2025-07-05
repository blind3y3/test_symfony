<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CartItemAddDto;
use App\Dto\CartItemCreateDto;
use App\Dto\PermissionException;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class CartItemService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CartItemRepository $cartItemRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function create(User $user, CartItemAddDto $dto): CartItem
    {
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['id' => $dto->getProductId()]) ?? throw new EntityNotFoundException('Product');

        $cartItemCreateDto = new CartItemCreateDto($user, $product);

        return $this->cartItemRepository->create($cartItemCreateDto, $dto->getQuantity());
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
