<?php

namespace App\Repository;

use App\Entity\AdoptionApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdoptionApplication>
 */
class AdoptionApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdoptionApplication::class);
    }

    /**
     * Returns all applications with their user and animal eagerly loaded,
     * sorted so pending applications appear first, then by most recent.
     *
     * @return AdoptionApplication[]
     */
    public function findAllWithDetails(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.user', 'u')
            ->addSelect('u')
            ->leftJoin('a.animal', 'an')
            ->addSelect('an')
            ->leftJoin('u.profile', 'p')
            ->addSelect('p')
            ->leftJoin('p.housingType', 'ht')
            ->addSelect('ht')
            ->addOrderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}