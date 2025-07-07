<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Order;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class OrderSerializer
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function serialize(Order $order): string
    {
        return $this->serializer->serialize($order, 'json', ['groups' => 'api-view']);
    }

    /**
     * @throws ExceptionInterface
     */
    public function serializeList(array $orders): string
    {
        return $this->serializer->serialize($orders, 'json', ['groups' => ['api-view']]);
    }
}
