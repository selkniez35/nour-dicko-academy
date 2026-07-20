<?php

namespace App\Repository;

use App\Entity\CourseSession;
use App\Entity\Recording;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recording>
 */
class RecordingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recording::class);
    }

    /**
     * @return Recording[]
     */
    public function findForSession(CourseSession $session): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.courseSession = :session')
            ->setParameter('session', $session)
            ->orderBy('r.uploadedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Recording[]
     */
    public function findForStudent(User $student): array
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.courseSession', 's')->addSelect('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->innerJoin('s.students', 'st')
            ->andWhere('st = :student')
            ->setParameter('student', $student)
            ->orderBy('r.uploadedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Recording[]
     */
    public function findForTeacher(User $teacher): array
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.courseSession', 's')->addSelect('s')
            ->leftJoin('s.plan', 'p')->addSelect('p')
            ->andWhere('s.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->orderBy('r.uploadedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
