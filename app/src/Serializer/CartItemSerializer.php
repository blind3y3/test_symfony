<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\CartItem;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class CartItemSerializer
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function serialize(CartItem $cartItem): string
    {
        return $this->serializer->serialize($cartItem, 'json', ['groups' => 'api-view']);
    }
}
