<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserAlreadyExistsException;
use App\Request\UserRegisterRequest;
use App\Responder\JsonResponder;
use App\Serializer\UserSerializer;
use App\Service\RegisterService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class RegisterController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     * @throws \Symfony\Component\Messenger\Exception\ExceptionInterface
     *
     * @noinspection PhpRedundantCatchClauseInspection
     */
    #[Route('/api/register', methods: ['POST'])]
    public function register(
        UserRegisterRequest $request,
        RegisterService $registerService,
        JsonResponder $responder,
        UserSerializer $serializer,
    ): Response {
        try {
            $user = $registerService->register($request->toDto());
        } catch (UniqueConstraintViolationException|UserAlreadyExistsException) {
            return new JsonResponse(['error' => 'User with this credentials already exists'],
                Response::HTTP_BAD_REQUEST);
        }

        return $responder->respond($serializer->serialize($user), Response::HTTP_CREATED);
    }
}
