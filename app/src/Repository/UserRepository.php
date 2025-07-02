<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Dto\UserRegisterDto;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(User $user, UserRegisterDto $dto, string $hashedPassword): User
    {
        $user
            ->setName($dto->getName())
            ->setPhone($dto->getPhone())
            ->setEmail($dto->getEmail())
            ->setPasswordHash($hashedPassword);

        $this->registry->getManager()->persist($user);
        $this->registry->getManager()->flush();

        return $user;
    }

    public function checkUserWithThisEmailOrPhoneExists(string $email, string $phone): bool
    {
        return (bool) $this
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->orWhere('u.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()->getResult();
    }
}
