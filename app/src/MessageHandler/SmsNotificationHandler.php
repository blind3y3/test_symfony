<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SmsNotification;
use App\Repository\SmsLogRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'doctrine')]
readonly class SmsNotificationHandler
{
    public function __construct(private SmsLogRepository $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SmsNotification $sms): void
    {
        $this->repository->create($sms->getUserId(), $sms->getMessage());
    }
}
