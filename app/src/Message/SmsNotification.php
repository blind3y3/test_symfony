<?php

declare(strict_types=1);

namespace App\Message;

readonly class SmsNotification
{
    public function __construct(
        readonly int $userId,
        readonly string $message,
        readonly string $phone,
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

    public function getPhone(): string
    {
        return $this->phone;
    }
}
