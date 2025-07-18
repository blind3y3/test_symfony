<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
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

    public function create(User $user, Product $product, int $quantity): CartItem
    {
        $cartItem = new CartItem();
        $cartItem->setUser($user);
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $this->registry->getManager()->persist($cartItem);
        $this->registry->getManager()->flush();

        return $cartItem;
    }

    public function isUserHaveAccess(User $user, CartItem $cartItem): bool
    {
        return (bool) $this
            ->createQueryBuilder('ci')
            ->where('ci.id = :cartItemId')
            ->setParameter('cartItemId', $cartItem->getId())
            ->andWhere('ci.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function delete(CartItem $cartItem): void
    {
        $this->registry->getManager()->remove($cartItem);
        $this->registry->getManager()->flush();
    }
}
