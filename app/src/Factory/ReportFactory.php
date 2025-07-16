<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Report;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ReportFactory
{
    public function create(): Report
    {
        $report = new Report();
        $report
            ->setStatus(Report::STATUS_CREATED)
            ->setBadge(Uuid::v7())
            ->setCreatedAt(new DateTimeImmutable());

        return $report;
    }
}
