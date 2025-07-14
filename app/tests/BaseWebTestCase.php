<?php

declare(strict_types=1);

namespace App\Tests;

use App\Kernel;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTestCase extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected static function getData(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true);
    }

    /**
     * @throws Exception
     */
    protected static function setJWTToken(KernelBrowser $client): KernelBrowser
    {
        $token = self::tryGetJWTToken($client);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }

    /**
     * @throws Exception
     */
    protected static function tryGetJWTToken(KernelBrowser $client): string
    {
        $client->jsonRequest(
            'POST',
            '/api/login_check',
            [
                'email' => 'test@test.test',
                'password' => 'test',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        return $data['token'] ?? throw new Exception('Token not found');
    }
}
