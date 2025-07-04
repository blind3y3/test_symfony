<?php

declare(strict_types=1);

namespace App\Tests\Application\Sms;

use App\Message\SmsNotification;
use App\MessageHandler\SmsNotificationHandler;
use App\Repository\SmsLogRepository;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SmsNotificationHandlerTest extends KernelTestCase
{
    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function testSmsNotificationHandler(): void
    {
        $repository = $this->createMock(SmsLogRepository::class);
        $repository->expects($this->once())
            ->method('create')
            ->with(1, 'Welcome!');

        $sms = $this->createMock(SmsNotification::class);
        $sms->method('getUserId')->willReturn(1);
        $sms->method('getMessage')->willReturn('Welcome!');

        $handler = new SmsNotificationHandler($repository);
        $handler($sms);
    }
}
