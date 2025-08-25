<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataKeeper\UserRole;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Admin')
            ->setPhone('0123456789')
            ->setEmail('admin@admin.local')
            ->setPasswordHash(password_hash('admin', PASSWORD_BCRYPT))
            ->setRole(UserRole::ADMIN->value);

        $manager->persist($user);
        $manager->flush();
    }
}
