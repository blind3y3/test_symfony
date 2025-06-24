<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\BaseValidationException;
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

        $response = new JsonResponse([
            'message' => 'This error was caught by our custom exception handler',
            'error' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ]);

        $event->setResponse($response);
    }
}
