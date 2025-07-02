<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Dto\CartItemCreateDto;
use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartItem>
 */
class CartItemRepository extends ServiceEntityRepository
{
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function create(CartItemCreateDto $dto, int $quantity): CartItem
    {
        $cartItem = new CartItem();
        $cartItem->setProduct($dto->getProduct());
        $cartItem->setUser($dto->getUser());
        $cartItem->setQuantity($quantity);

        $this->registry->getManager()->persist($cartItem);
        $this->registry->getManager()->flush();

        return $cartItem;
    }
}
