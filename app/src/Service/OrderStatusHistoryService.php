<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderStatusHistoryRepository;

readonly class OrderStatusHistoryService
{
    public function __construct(
        private OrderStatusHistoryRepository $orderStatusHistoryRepository,
    ) {
    }

    public function updateOrderStatus(Order $order): void
    {
        $this->orderStatusHistoryRepository->createByOrder($order);
    }
}
