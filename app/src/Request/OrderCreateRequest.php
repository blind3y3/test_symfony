<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\Order;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

readonly class OrderCreateRequest extends AbstractRequest
{
    #[NotBlank]
    #[Type('string')]
    #[Assert\Choice(callback: [Order::class, 'getDeliveryMethods'], message: 'Wrong delivery method')]
    protected string $deliveryMethod;

    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }
}
