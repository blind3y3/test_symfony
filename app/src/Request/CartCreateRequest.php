<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\CartItemAddDto;
use App\Exception\ProductNotFoundOrNotActiveException;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CartCreateRequest extends AbstractRequest
{
    #[NotBlank]
    #[Type('integer')]
    #[Positive]
    public int $productId;

    #[NotBlank]
    #[Type('integer')]
    #[Positive]
    public int $quantity;

    public function __construct(
        ValidatorInterface $validator,
        RequestStack $requestStack,
        private ProductRepository $productRepository,
    ) {
        parent::__construct($validator, $requestStack);
    }

    /**
     * @throws ProductNotFoundOrNotActiveException
     */
    private function checkProductExistsAndActive(): void
    {
        $isProductExistsAndActive = $this->productRepository->isProductExistsAndActive($this->productId);
        if (!$isProductExistsAndActive) {
            throw new ProductNotFoundOrNotActiveException();
        }
    }

    /**
     * @throws ProductNotFoundOrNotActiveException
     */
    public function toDto(): CartItemAddDto
    {
        // @TODO Вытащить продукт из репозитория и сразу запихать в dto?
        $this->checkProductExistsAndActive();

        return new CartItemAddDto($this->productId, $this->quantity);
    }
}
