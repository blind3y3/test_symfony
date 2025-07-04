<?php

declare(strict_types=1);

namespace App\Tests\Application\User;

use App\Tests\BaseWebTestCase;

class UserRegisterTest extends BaseWebTestCase
{
    public function testUserRegister(): void
    {
        $testName = 'test user';
        $testEmail = 'test@test.com';
        $testPhone = '88001110000';
        $testPassword = '123456';

        $client = static::createClient();
        $client->request('POST', '/api/register', content: json_encode([
            'name' => $testName,
            'email' => $testEmail,
            'phone' => $testPhone,
            'password' => $testPassword,
        ]
        ));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $data = self::getData($client);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals($testName, $data['name']);
        $this->assertEquals($testEmail, $data['email']);
        $this->assertEquals($testPhone, $data['phone']);

        $this->assertArrayNotHasKey('password', $data);
    }
}
