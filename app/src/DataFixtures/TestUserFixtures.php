<?php

namespace App\DataFixtures;

use App\DataKeeper\UserRole;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestUserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setName('Test User')
            ->setPhone('Test User')
            ->setEmail('test@test.test')
            ->setPasswordHash(password_hash('test', PASSWORD_BCRYPT))
            ->setRole(UserRole::USER->value)
            ->setCreatedAt(new DateTimeImmutable());

        $manager->persist($user);
        $manager->flush();
    }
}
