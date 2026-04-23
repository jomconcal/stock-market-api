<?php

namespace App\Domain\AlphaVantage\Repository;

use App\Domain\AlphaVantage\Entity\AlphaVantageLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlphaVantageLog>
 */
class AlphaVantageLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlphaVantageLog::class);
    }

    public function save(AlphaVantageLog $alphaVantageLog): void
    {
        $this->getEntityManager()->persist($alphaVantageLog);
        $this->getEntityManager()->flush();
    }
}
