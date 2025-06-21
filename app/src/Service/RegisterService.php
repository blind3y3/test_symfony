<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\BaseValidationException;
use App\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class RegisterService
{
    public function __construct(
        private UserFactory $userFactory,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws BaseValidationException
     */
    public function register(array $requestData): User
    {
        $password = $requestData['password'] ?? null;

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }

        $user = $this->userFactory->create();
        $user
            ->setName($requestData['name'] ?? '')
            ->setPhone($requestData['phone'] ?? '')
            ->setEmail($requestData['email'] ?? '')
            ->setPasswordHash($hashedPassword ?? '');

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsBag = [];
            foreach ($errors as $error) {
                if ('password_hash' === $error->getPropertyPath()) {
                    $errorsBag[] = ['password' => $error->getMessage()];
                    continue;
                }
                $errorsBag[] = [$error->getPropertyPath() => $error->getMessage()];
            }
            throw new BaseValidationException((string) $errors, $errorsBag);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
