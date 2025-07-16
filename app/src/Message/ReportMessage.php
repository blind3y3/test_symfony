<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Uid\Uuid;

readonly class ReportMessage
{
    public function __construct(private Uuid $uuid)
    {
    }

    public function getReportUuid(): Uuid
    {
        return $this->uuid;
    }
}
