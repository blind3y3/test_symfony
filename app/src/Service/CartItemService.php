<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Exception\BaseValidationException;
use App\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CartItemService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private ValidationService $validationService,
    ) {
    }

    /**
     * @throws BaseValidationException
     * @throws EntityNotFoundException
     */
    public function create(User $user, ?int $productId, ?int $quantity): CartItem
    {
        // @TODO валидация

        if (!$quantity) {
            throw new BaseValidationException(errors: ['quantity' => 'Quantity must be greater than 0']);
        }

        $product = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['id' => $productId]) ?? throw new EntityNotFoundException('Product');

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setUser($user);
        $cartItem->setQuantity($quantity);

        $errors = $this->validator->validate($cartItem);
        $this->validationService->collectErrors($errors);

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $cartItem;
    }
}
