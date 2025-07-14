<?php

declare(strict_types=1);

namespace App\Tests\Application\User;

use App\Repository\UserRepository;
use App\Tests\BaseWebTestCase;

class UserLoginTest extends BaseWebTestCase
{
    public function testUserLogin(): void
    {
        // @TODO проверка авторизации через JWT токен
        $client = static::createClient();
        $userRepository = $this->getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('test@test.test');
        $client->loginUser($user);

        $client->request('POST', '/api/cart', content: json_encode([
            'productId' => 1,
            'quantity' => 1,
        ]
        ));

        $this->assertResponseIsSuccessful();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $data = self::getData($client);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(1, $data['quantity']);
    }
}
