<?php

namespace App\Repository;

use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Enum\MembershipStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membership>
 */
class MembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }

    /**
     * @return Membership[]
     */
    public function findLatest(int $limit = 10): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.userProfile', 'profile')->addSelect('profile')
            ->leftJoin('profile.user', 'user')->addSelect('user')
            ->leftJoin('m.plan', 'plan')->addSelect('plan')
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Membership[]
     */
    public function findPending(int $limit = 20): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.userProfile', 'profile')->addSelect('profile')
            ->leftJoin('m.plan', 'plan')->addSelect('plan')
            ->andWhere('m.status = :status')
            ->setParameter('status', MembershipStatus::PENDING->value)
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Membership[]
     */
    public function findAllOrdered(int $limit = 100): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.userProfile', 'profile')->addSelect('profile')
            ->leftJoin('profile.user', 'user')->addSelect('user')
            ->leftJoin('m.plan', 'plan')->addSelect('plan')
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Compte les inscriptions créées sur les {$days} derniers jours.
     */
    public function countRecent(int $days = 7): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->andWhere('m.createdAt >= :since')
            ->setParameter('since', new \DateTimeImmutable('-' . $days . ' days'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countPending(): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->andWhere('m.status = :status')
            ->setParameter('status', MembershipStatus::PENDING->value)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countForPlan(MembershipPlan $plan): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->andWhere('m.plan = :plan')
            ->setParameter('plan', $plan)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
