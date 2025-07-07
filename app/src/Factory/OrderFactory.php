<?php

declare(strict_types=1);

namespace App\Factory;

use App\DataKeeper\OrderStatus;
use App\Entity\Order;
use App\Entity\User;

class OrderFactory
{
    public function createPaidByUser(User $user): Order
    {
        $order = new Order();
        $order
            ->setUser($user)
            ->setStatus(OrderStatus::PAID->value)
            ->setCreatedAt(new \DateTimeImmutable());

        return $order;
    }
}
