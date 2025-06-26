<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Repository;

use App\Entity\SmsLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SmsLog>
 */
class SmsLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SmsLog::class);
    }

    /**
     * @throws Exception
     */
    public function create(int $userId, string $message): void
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'INSERT INTO sms_log (user_id, message, sent_at) values (?, ?, ?)';
        $conn->executeQuery($sql, [$userId, $message, $now]);
    }
}
