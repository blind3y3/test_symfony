<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\CartItemDeleteDto;
use App\Entity\CartItem;
use App\Exception\EntityNotFoundException;
use App\Repository\CartItemRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CartItemDeleteRequest extends AbstractRequest
{
    #[NotBlank]
    #[Type('integer')]
    #[Positive]
    protected int $cartItemId;

    public function __construct(
        ValidatorInterface $validator,
        RequestStack $requestStack,
        private CartItemRepository $cartItemRepository,
    ) {
        parent::__construct($validator, $requestStack);
    }

    /**
     * @throws EntityNotFoundException
     */
    private function tryGetCartItem(): CartItem
    {
        $cartItem = $this->cartItemRepository->find($this->cartItemId);
        if (!$cartItem) {
            throw new EntityNotFoundException('Cart Item');
        }

        return $cartItem;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function toDto(): CartItemDeleteDto
    {
        $cartItem = $this->tryGetCartItem();

        return new CartItemDeleteDto($cartItem);
    }
}
