<?php

declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ProductSerializer
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function serializeList(array $products): string
    {
        return $this->serializer->serialize($products, 'json', ['groups' => ['api-view']]);
    }
}
