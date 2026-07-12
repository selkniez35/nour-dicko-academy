<?php

namespace App\Repository;

use App\Entity\CoachGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoachGroup>
 */
class CoachGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoachGroup::class);
    }

    /**
     * @return CoachGroup[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.coach', 'c')->addSelect('c')
            ->orderBy('g.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
