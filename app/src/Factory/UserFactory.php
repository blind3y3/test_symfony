<?php

declare(strict_types=1);

namespace App\Factory;

use App\DataKeeper\UserRole;
use App\Entity\User;

class UserFactory
{
    public function create(): User
    {
        $user = new User();
        $user
            ->setRole(UserRole::USER->value)
            ->setCreatedAt(new \DateTimeImmutable());

        return $user;
    }
}
