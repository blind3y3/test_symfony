<?php

declare(strict_types=1);

namespace App\Tests\Application\User;

use App\Tests\BaseWebTestCase;
use Exception;

class UserLoginTest extends BaseWebTestCase
{
    /**
     * @throws Exception
     */
    public function testUserLogin(): void
    {
        $client = $this->createAuthenticatedClient();

        $client->jsonRequest('GET', '/api/orders');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        /* У тестового пользователя нет заказов */
        $this->assertEquals('[]', $client->getResponse()->getContent());
    }
}
