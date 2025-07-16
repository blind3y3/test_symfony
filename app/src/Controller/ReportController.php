<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\EntityNotFoundException;
use App\Responder\JsonResponder;
use App\Serializer\ReportSerializer;
use App\Service\ReportService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ReportController
{
    /**
     * @throws ExceptionInterface
     * @throws \Symfony\Component\Messenger\Exception\ExceptionInterface
     */
    #[Route(path: '/api/report', methods: ['POST'])]
    public function generate(
        ReportService $reportService,
        ReportSerializer $serializer,
        JsonResponder $responder,
    ): Response {
        $report = $reportService->generate();

        return $responder->respond($serializer->serialize($report));
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route(path: '/api/report/{uuid}', methods: ['GET'])]
    public function getFile(
        string $uuid,
        ReportService $reportService,
        ParameterBagInterface $parameterBag,
    ): BinaryFileResponse {
        $report = $reportService->getByUuid($uuid);
        $path = $parameterBag->get('kernel.project_dir').'/public/'.$report->getFilePath();

        $response = new BinaryFileResponse($path);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            sprintf('%s.jsonl', $report->getBadge())
        );

        return $response;
    }
}
