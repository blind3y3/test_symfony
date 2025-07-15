<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\CartItemAddDto;
use App\Entity\Product;
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
    private function tryGetProduct(): Product
    {
        $product = $this->productRepository->getActiveProductById($this->productId);
        if (null === $product) {
            throw new ProductNotFoundOrNotActiveException();
        }

        return $product;
    }

    /**
     * @throws ProductNotFoundOrNotActiveException
     */
    public function toDto(): CartItemAddDto
    {
        $product = $this->tryGetProduct();

        return new CartItemAddDto($product, $this->quantity);
    }
}
