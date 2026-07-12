<?php

namespace App\Repository;

use App\Entity\MembershipPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembershipPlan>
 */
class MembershipPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembershipPlan::class);
    }

    /**
     * @return MembershipPlan[]
     */
    public function findLatest(int $limit = 10): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.features', 'f')->addSelect('f')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return MembershipPlan[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.features', 'f')->addSelect('f')
            ->orderBy('m.level', 'ASC')
            ->addOrderBy('m.label', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
