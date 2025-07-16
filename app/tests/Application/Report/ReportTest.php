<?php

declare(strict_types=1);

namespace App\Tests\Application\Report;

use App\Tests\BaseWebTestCase;
use Exception;
use Symfony\Component\Uid\Uuid;

class ReportTest extends BaseWebTestCase
{
    /**
     * @throws Exception
     */
    public function testGenerateReportEndpointResponse(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->jsonRequest('POST', '/api/report');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $data = $this->getData($client);

        $this->assertArrayHasKey('badge', $data);
        $this->assertEquals(Uuid::isValid(Uuid::v7()->toString()), Uuid::isValid($data['badge']));
        $this->assertEquals('created', $data['status']);
    }
}
