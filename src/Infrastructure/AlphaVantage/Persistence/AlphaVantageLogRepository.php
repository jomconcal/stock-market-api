<?php

namespace App\Infrastructure\AlphaVantage\Persistence;

use App\Domain\AlphaVantage\Entity\AlphaVantageLog;
use App\Domain\AlphaVantage\Repository\AlphaVantageLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlphaVantageLog>
 */
class AlphaVantageLogRepository extends ServiceEntityRepository implements AlphaVantageLogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlphaVantageLog::class);
    }

    #[\Override]
    public function save(AlphaVantageLog $alphaVantageLog): void
    {
        $this->getEntityManager()->persist($alphaVantageLog);
        $this->getEntityManager()->flush();
    }
}
