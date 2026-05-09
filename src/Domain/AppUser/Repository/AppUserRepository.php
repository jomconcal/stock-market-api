<?php

namespace App\Domain\AppUser\Repository;

use App\Domain\AppUser\Entity\AppUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppUser>
 */
class AppUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

}
