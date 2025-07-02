<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\UserRegisterDto;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Message\SmsNotification;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class RegisterService
{
    public function __construct(
        private UserFactory $userFactory,
        private UserRepository $userRepository,
        private MessageBusInterface $messageBus,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function register(UserRegisterDto $dto): User
    {
        $user = $this->userFactory->create();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $dto->getPassword());
        $this->userRepository->create($user, $dto, $hashedPassword);

        $this->messageBus->dispatch(new SmsNotification(
            $user->getId(),
            SmsNotification::MESSAGE,
        ));

        return $user;
    }
}
