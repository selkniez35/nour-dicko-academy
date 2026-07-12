<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return User[]
     */
    public function findForAudience(string $audience): array
    {
        $audience = strtoupper($audience);
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('u.profile', 'p')->addSelect('p');

        if ($audience === 'ALL') {
            return $qb->getQuery()->getResult();
        }

        if ($audience === 'INCLUSIVE') {
            $qb->andWhere('p.adaptedSupport = :adapted OR p.preferredGroup = :group')
                ->setParameter('adapted', true)
                ->setParameter('group', 'INCLUSIVE');

            return $qb->getQuery()->getResult();
        }

        $qb->andWhere('p.preferredGroup = :group')
            ->setParameter('group', $audience);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return User[]
     */
    public function findStudents(): array
    {
        return $this->findByRole(UserRole::USER->value);
    }

    /**
     * @return User[]
     */
    public function findTeachers(): array
    {
        return $this->findByRole(UserRole::COACH->value);
    }

    public function countStudents(): int
    {
        return count($this->findStudents());
    }

    public function countTeachers(): int
    {
        return count($this->findTeachers());
    }

    /**
     * @return User[]
     */
    private function findByRole(string $role): array
    {
        $users = $this->createQueryBuilder('u')
            ->leftJoin('u.profile', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();

        $filtered = array_filter($users, static fn (User $user): bool => in_array($role, $user->getRoles(), true));

        usort($filtered, static function (User $a, User $b): int {
            $aProfile = $a->getProfile();
            $bProfile = $b->getProfile();

            $aName = $aProfile ? trim(($aProfile->getLastName() ?? '') . ' ' . ($aProfile->getFirstName() ?? '')) : (string) $a->getEmail();
            $bName = $bProfile ? trim(($bProfile->getLastName() ?? '') . ' ' . ($bProfile->getFirstName() ?? '')) : (string) $b->getEmail();

            return strcasecmp($aName, $bName);
        });

        return array_values($filtered);
    }

}
