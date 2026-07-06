<?php

namespace App\Repository;

use App\Entity\ClubEvent;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClubEvent>
 */
class ClubEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClubEvent::class);
    }

    /**
     * @return ClubEvent[]
     */
    public function findPublishedUpcoming(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.registrations', 'r')->addSelect('r')
            ->andWhere('e.isPublished = :published')
            ->andWhere('e.endAt >= :now')
            ->setParameter('published', true)
            ->setParameter('now', new DateTimeImmutable('-1 day'))
            ->orderBy('e.startAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ClubEvent[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.registrations', 'r')->addSelect('r')
            ->orderBy('e.startAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
