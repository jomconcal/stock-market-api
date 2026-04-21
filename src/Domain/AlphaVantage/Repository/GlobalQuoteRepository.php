<?php

namespace App\Domain\AlphaVantage\Repository;

use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GlobalQuoteEntity>
 */
class GlobalQuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GlobalQuoteEntity::class);
    }

    public function save(GlobalQuoteEntity $entity): void{
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findByLastFetchedAndSymbol(string $symbol ):?GlobalQuoteEntity{

        $start = new \DateTimeImmutable('today');
        $end = new \DateTimeImmutable('tomorrow');

        $qB = $this->createQueryBuilder('gQ');
        $qB->andWhere('gQ.symbol = :symbol');
        $qB->andWhere('gQ.fetchedAt BETWEEN :start and :end');
        $qB->setParameter('symbol', $symbol);
        $qB->setParameter('start', $start);
        $qB->setParameter('end', $end);

        $query= $qB->getQuery();
        return $query->getOneOrNullResult();
    }
}
