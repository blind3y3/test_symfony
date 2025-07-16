<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Report;
use App\Message\ReportMessage;
use App\Repository\OrderItemRepository;
use App\Repository\ReportRepository;
use JsonException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'amqp')]
readonly class ReportMessageHandler
{
    public function __construct(
        private OrderItemRepository $orderItemRepository,
        private ReportRepository $reportRepository,
        private Filesystem $filesystem,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function __invoke(ReportMessage $message): void
    {
        $reportUuid = $message->getReportUuid();
        $result = '';
        $orderItems = $this->orderItemRepository->findAll();

        foreach ($orderItems as $orderItem) {
            $item = [
                'orderItemId' => $orderItem->getId(),
                'quantity' => $orderItem->getQuantity(),
                'product' => [
                    'name' => $orderItem->getProduct()->getName(),
                    'price' => $orderItem->getProduct()->getPrice(),
                ],
                'user' => [
                    'id' => $orderItem->getOrder()->getUser()->getId(),
                    'name' => $orderItem->getOrder()->getUser()->getName(),
                ],
            ];

            $result .= json_encode($item, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE).PHP_EOL;
        }

        $this->filesystem->mkdir('public/reports');
        $this->filesystem
            ->dumpFile(
                sprintf('public/reports/%s.jsonl', $reportUuid),
                $result
            );

        $report = $this->reportRepository->findOneBy(['badge' => $reportUuid]);
        $report
            ->setFilePath(sprintf('reports/%s.jsonl', $reportUuid))
            ->setStatus(Report::STATUS_FINISHED);
        $this->reportRepository->save($report);
    }
}
