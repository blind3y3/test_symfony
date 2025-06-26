<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\BaseValidationException;
use App\Factory\UserFactory;
use App\Message\SmsNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class RegisterService
{
    public function __construct(
        private UserFactory $userFactory,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws BaseValidationException
     * @throws ExceptionInterface
     */
    public function register(array $requestData): User
    {
        $password = $requestData['password'] ?? null;

        if ($password) {
            // @TODO перейти на UserPasswordHasherInterface
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
            throw new BaseValidationException((string)$errors, $errorsBag);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->messageBus->dispatch(new SmsNotification(
            $user->getId(),
            SMSNotification::MESSAGE,
            $user->getPhone(),
        ));

        return $user;
    }
}
