<?php

namespace App\Repository;

use App\Entity\CourseSession;
use App\Entity\MembershipPlan;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseSession>
 */
class CourseSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseSession::class);
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countForPlan(MembershipPlan $plan): int
    {
        return (int) $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->andWhere('s.plan = :plan')
            ->setParameter('plan', $plan)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countForTeacher(User $teacher): int
    {
        return (int) $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->andWhere('s.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return CourseSession[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->leftJoin('s.teacher', 't')->addSelect('t')
            ->orderBy('s.startsAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return CourseSession[]
     */
    public function findUpcoming(int $limit = 20): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->leftJoin('s.teacher', 't')->addSelect('t')
            ->andWhere('s.startsAt >= :now')
            ->setParameter('now', new \DateTimeImmutable('today'))
            ->orderBy('s.startsAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return CourseSession[]
     */
    public function findForStudent(User $student): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->leftJoin('s.teacher', 't')->addSelect('t')
            ->innerJoin('s.students', 'st')
            ->andWhere('st = :student')
            ->setParameter('student', $student)
            ->orderBy('s.startsAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return CourseSession[]
     */
    public function findForTeacher(User $teacher): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->leftJoin('s.students', 'st')->addSelect('st')
            ->andWhere('s.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->orderBy('s.startsAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
