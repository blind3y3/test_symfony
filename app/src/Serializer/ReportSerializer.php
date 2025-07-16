<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Report;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ReportSerializer
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function serialize(Report $report): string
    {
        return $this->serializer->serialize($report, 'json');
    }
}
