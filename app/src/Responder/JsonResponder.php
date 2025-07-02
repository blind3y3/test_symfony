<?php

declare(strict_types=1);

namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;

readonly class JsonResponder
{
    public function respond(
        mixed $payload,
        int $status = Response::HTTP_OK,
        array $headers = [],
    ): Response {
        $headers = array_merge($headers, ['Content-Type' => 'application/json']);

        return new Response($payload, $status, $headers);
    }
}
