<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\BaseValidationException;
use App\Exception\EntityNotFoundException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BaseValidationException) {
            $response = new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $exception->errors,
            ], Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);

            return;
        }

        if ($exception instanceof UniqueConstraintViolationException) {
            $response = new JsonResponse([
                'message' => 'User with this credentials already exists',
            ]);
            $event->setResponse($response);

            return;
        }

        if ($exception instanceof EntityNotFoundException) {
            $response = new JsonResponse([
                'message' => $exception->getMessage(),
            ]);
            $event->setResponse($response);

            return;
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
        ]);

        $event->setResponse($response);
    }
}
