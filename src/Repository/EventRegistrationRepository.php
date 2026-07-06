<?php

namespace App\Repository;

use App\Entity\ClubEvent;
use App\Entity\EventRegistration;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRegistration>
 */
class EventRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRegistration::class);
    }

    public function findOneForUser(ClubEvent $event, User $user): ?EventRegistration
    {
        return $this->findOneBy([
            'event' => $event,
            'user' => $user,
        ]);
    }

    /**
     * @return EventRegistration[]
     */
    public function findForEvent(ClubEvent $event): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.user', 'u')->addSelect('u')
            ->andWhere('r.event = :event')
            ->setParameter('event', $event)
            ->orderBy('r.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
