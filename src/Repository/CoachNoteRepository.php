<?php

namespace App\Repository;

use App\Entity\CoachNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoachNote>
 */
class CoachNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoachNote::class);
    }

    /**
     * @param int[] $sessionIds
     * @return CoachNote[]
     */
    public function findForSessions(array $sessionIds): array
    {
        if ($sessionIds === []) {
            return [];
        }

        return $this->createQueryBuilder('n')
            ->leftJoin('n.member', 'm')->addSelect('m')
            ->leftJoin('n.coach', 'c')->addSelect('c')
            ->andWhere('n.trainingSession IN (:sessionIds)')
            ->setParameter('sessionIds', $sessionIds)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
