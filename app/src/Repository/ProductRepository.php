<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function isProductExistsAndActive(int $productId): bool
    {
        return (bool) $this
            ->createQueryBuilder('p')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId)
            ->andWhere('p.is_active = :isActive')
            ->setParameter('isActive', true)
            ->getQuery()->getResult();
    }
}
