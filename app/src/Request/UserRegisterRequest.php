<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\UserRegisterDto;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserRegisterRequest extends AbstractRequest
{
    #[NotBlank]
    #[Type('string')]
    public string $name;

    #[NotBlank]
    #[Type('string')]
    public string $email;

    #[NotBlank]
    #[Type('string')]
    public string $phone;

    #[NotBlank]
    #[Type('string')]
    public string $password;

    public function __construct(
        ValidatorInterface $validator,
        RequestStack $requestStack,
        private UserRepository $userRepository,
    ) {
        parent::__construct($validator, $requestStack);
    }

    /**
     * @throws UserAlreadyExistsException
     */
    private function checkUserExists(): void
    {
        $isUserExists = $this->userRepository->checkUserWithThisEmailOrPhoneExists($this->email, $this->phone);
        if ($isUserExists) {
            throw new UserAlreadyExistsException();
        }
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function toDto(): UserRegisterDto
    {
        $this->checkUserExists();

        return new UserRegisterDto($this->name, $this->email, $this->phone, $this->password);
    }
}
