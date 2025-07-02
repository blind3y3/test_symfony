<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CartItemAddDto;
use App\Dto\CartItemCreateDto;
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
}
