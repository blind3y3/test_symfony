<?php

declare(strict_types=1);

namespace App\Tests;

use App\Kernel;
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
}
