<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BaseValidationException;
use App\Responder\JsonResponder;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class RegisterController extends AbstractController
{
    /**
     * @throws BaseValidationException
     * @throws ExceptionInterface
     * @throws \Symfony\Component\Messenger\Exception\ExceptionInterface
     */
    #[Route('/api/register', methods: ['POST'])]
    public function register(
        Request $request,
        RegisterService $registerService,
        JsonResponder $responder,
    ): Response {
        $requestData = json_decode($request->getContent(), true);
        $user = $registerService->register($requestData);

        return $responder->respond($user, Response::HTTP_CREATED);
    }
}
