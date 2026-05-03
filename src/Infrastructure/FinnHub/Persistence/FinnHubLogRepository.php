<?php

declare(strict_types=1);

namespace App\Infrastructure\FinnHub\Persistence;

use App\Domain\FinnHub\Entity\FinnHubLog;
use App\Domain\FinnHub\Repository\FinnHubLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FinnHubLog>
 */
class FinnHubLogRepository extends ServiceEntityRepository implements FinnHubLogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinnHubLog::class);
    }

    #[\Override]
    public function save(FinnHubLog $finnHubLog): void
    {
        $this->getEntityManager()->persist($finnHubLog);
        $this->getEntityManager()->flush();
    }
}
