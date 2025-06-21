<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BaseValidationException;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    /**
     * @throws BaseValidationException
     */
    #[Route('/api/register', methods: ['POST'])]
    public function register(
        Request $request,
        RegisterService $registerService,
    ): Response {
        $requestData = json_decode($request->getContent(), true);
        $user = $registerService->register($requestData);

        return new JsonResponse([
            'message' => 'User created!',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }
}
