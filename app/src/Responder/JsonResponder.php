<?php

declare(strict_types=1);

namespace App\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class JsonResponder
{
    public function __construct(private SerializerInterface&NormalizerInterface $serializer)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function respond(
        array|object $data,
        int $status = Response::HTTP_OK,
        array $headers = [],
        array $context = [],
    ): JsonResponse {
        $normalized = $this->serializer->normalize(
            $data,
            null,
            array_merge(
                [
                    AbstractNormalizer::IGNORED_ATTRIBUTES => [
                        'passwordHash',
                        'password',
                        'roles',
                        'userIdentifier',
                        'smsLogs',
                    ],
                ],
                [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'],
                $context));

        return new JsonResponse($normalized, $status, $headers);
    }
}
