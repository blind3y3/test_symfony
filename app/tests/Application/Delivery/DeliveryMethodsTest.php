<?php

declare(strict_types=1);

namespace App\Tests\Application\Delivery;

use App\Entity\Order;
use App\Tests\BaseWebTestCase;

class DeliveryMethodsTest extends BaseWebTestCase
{
    public function testGetDeliveryMethods(): void
    {
        $client = static::createClient();
        $client->jsonRequest('GET', '/api/delivery-methods');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = $this->getData($client);
        $this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys(Order::getDeliveryMethods(), $data, Order::getDeliveryMethods());
    }
}
