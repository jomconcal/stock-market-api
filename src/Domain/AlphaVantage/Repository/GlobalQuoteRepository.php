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

    public function save(GlobalQuoteEntity $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findByFetchedTodayAndSymbol(string $symbol): ?GlobalQuoteEntity
    {
        $start = new \DateTime('today');
        $end = new \DateTime('tomorrow');

        $qB = $this->createQueryBuilder('gQ');
        $qB->andWhere('gQ.symbol = :symbol');
        $qB->andWhere('gQ.fetchedAt BETWEEN :start and :end');
        $qB->setParameter('symbol', $symbol);
        $qB->setParameter('start', $start);
        $qB->setParameter('end', $end);

        $query = $qB->getQuery();

        /** @var GlobalQuoteEntity|null $result */
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function replace(GlobalQuoteEntity $globalQuoteEntity): void
    {
        $oldEntity = $this->getBySymbolAndLatestTradingDay(
            $globalQuoteEntity->getSymbol(),
            $globalQuoteEntity->getLatestTradingDay()
        );

        if (is_null($oldEntity)) {
            $this->save($globalQuoteEntity);

            return;
        }

        $oldEntity->setFetchedAt(new \DateTime());
        $this->getEntityManager()->flush();
    }

    public function getBySymbolAndLatestTradingDay(
        string $symbol,
        string $latestTradingDay): ?GlobalQuoteEntity
    {
        $qB = $this->createQueryBuilder('gQ');
        $qB->andWhere('gQ.symbol = :symbol');
        $qB->andWhere('gQ.latestTradingDay = :latestTradingDay');
        $qB->setParameter('symbol', $symbol);
        $qB->setParameter('latestTradingDay', $latestTradingDay);
        $query = $qB->getQuery();

        /** @var GlobalQuoteEntity|null $result */
        $result = $query->getOneOrNullResult();

        return $result;
    }
}
