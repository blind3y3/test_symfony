<?php

declare(strict_types=1);

namespace App\Tests\Application\Cart;

use App\Repository\CartItemRepository;
use App\Tests\BaseWebTestCase;
use Exception;

class CartItemTest extends BaseWebTestCase
{
    /**
     * @throws Exception
     */
    public function testCartItemAddAndCartItemDelete(): void
    {
        $client = $this->createAuthenticatedClient();

        $productId = 1;
        $quantity = 2;

        $client->jsonRequest('POST', '/api/cart', [
            'productId' => $productId,
            'quantity' => $quantity,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $data = $this->getData($client);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals($quantity, $data['quantity']);

        /** Проверка CartItem в репозитории */
        $cartItemRepository = $this->getContainer()->get(CartItemRepository::class);
        $cartItem = $cartItemRepository->findOneById($data['id']);
        $this->assertNotNull($cartItem);
        $this->assertEquals($productId, $cartItem->getProduct()->getId());
        $this->assertEquals($quantity, $cartItem->getQuantity());

        $client->jsonRequest('DELETE', '/api/cart', [
            'cartItemId' => $cartItem->getId(),
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = $this->getData($client);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('success', $data['message']);

        /** Проверка, что CartItem отсутствует в базе */
        $cartItem = $cartItemRepository->findOneById($cartItem->getId());
        $this->assertNull($cartItem);
    }
}
