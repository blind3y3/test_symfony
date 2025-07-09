<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderStatusHistory>
 */
class OrderStatusHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStatusHistory::class);
    }

    public function createByOrder(Order $order): void
    {
        $historyEntry = new OrderStatusHistory();
        $historyEntry
            ->setOrder($order)
            ->setStatus($order->getStatus())
            ->setChangedAt(new DateTimeImmutable());

        $this->getEntityManager()->persist($historyEntry);
        $this->getEntityManager()->flush();
    }
}
