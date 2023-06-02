<?php

namespace App\Repository;

use App\Entity\Notation;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Notation>
 *
 * @method Notation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notation[]    findAll()
 * @method Notation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notation::class);
    }

    public function save(Notation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Notation[] Returns an array of Notation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notation
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByPublication(Publication $entity)
    {
        return $this->createQueryBuilder('n')
            ->select('sum(n.value) as value')
            ->andWhere('n.publication = :publication')
            ->groupBy('n.publication')
            ->setParameter('publication', $entity)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    /**
     * @param Publication $publication
     * @param User $getUser
     * @return Notation|null
     * @throws NonUniqueResultException
     */
    public function liked(Publication $publication, User $getUser): ?Notation
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.publication = :publication')
            ->andWhere('n.user = :user')
            ->setParameter('publication', $publication)
            ->setParameter('user', $getUser)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
