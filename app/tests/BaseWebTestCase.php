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

    protected function getData(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true);
    }

    /**
     * @throws Exception
     */
    protected function createAuthenticatedClient(): KernelBrowser
    {
        $client = static::createClient();

        $client->jsonRequest(
            'POST',
            '/api/login_check',
            [
                'email' => 'test@test.test',
                'password' => 'test',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        if (!array_key_exists('token', $data)) {
            throw new Exception('Token not found');
        }

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
