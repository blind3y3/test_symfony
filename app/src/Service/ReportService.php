<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Report;
use App\Exception\EntityNotFoundException;
use App\Factory\ReportFactory;
use App\Message\ReportMessage;
use App\Repository\ReportRepository;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class ReportService
{
    public function __construct(
        private ReportFactory $reportFactory,
        private ReportRepository $reportRepository,
        private MessageBusInterface $bus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function generate(): Report
    {
        $report = $this->reportFactory->create();
        $this->reportRepository->save($report);
        $this->bus->dispatch(new ReportMessage($report->getBadge()));

        return $report;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getByUuid(string $uuid): Report
    {
        return $this->reportRepository->findOneBy(['badge' => $uuid]) ?? throw new EntityNotFoundException('Report');
    }
}
