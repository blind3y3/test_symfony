<?php

declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Tests\BaseWebTestCase;

class ProductsListTest extends BaseWebTestCase
{
    public function testGetProductsList(): void
    {
        $client = static::createClient();
        $client->jsonRequest('GET', '/api/products');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($client->getResponse()->getContent());
    }
}
