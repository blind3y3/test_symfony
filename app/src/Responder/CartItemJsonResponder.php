<?php

declare(strict_types=1);

namespace App\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

readonly class CartItemJsonResponder
{
    public function __construct(
        private NormalizerInterface $normalizer,
    ) {
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
        $normalized = $this->normalizer->normalize(
            $data,
            null,
            array_merge(
                [
                    AbstractNormalizer::IGNORED_ATTRIBUTES => [
                        'userId',
                        'productId',
                    ],
                ],
                $context));

        return new JsonResponse($normalized, $status, $headers);
    }
}
