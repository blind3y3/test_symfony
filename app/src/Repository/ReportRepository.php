<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Report>
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function save(Report $report): void
    {
        $this->getEntityManager()->persist($report);
        $this->getEntityManager()->flush();
    }
}
