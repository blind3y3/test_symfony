<?php

declare(strict_types=1);

namespace App\Message;

readonly class SmsNotification
{
    public function __construct(
        private int $userId,
        private string $message,
    ) {
    }

    public const MESSAGE = 'Welcome!';

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
