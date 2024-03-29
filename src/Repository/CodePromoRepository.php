<?php

namespace App\Repository;

use App\Entity\CodePromo;
use App\Entity\Notation;
use App\Entity\Publication;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodePromo>
 *
 * @method CodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromo[]    findAll()
 * @method CodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePromo::class);
    }

    public function save(CodePromo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CodePromo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findHot(): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin(Publication::class, 'p', 'WITH', 'p.codePromo = c.id')
            ->innerJoin(Notation::class, 'n', 'WITH', 'n.publication = p.id')
            ->groupBy('c.id')
            ->having('sum(n.value) >= 100')
            ->andWhere('c.expiredAt > :date')
            ->setParameter('date', new DateTime())
            ->getQuery()
            ->getResult()
        ;
    }


    public function findHotExpired()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin(Publication::class, 'p', 'WITH', 'p.codePromo = c.id')
            ->innerJoin(Notation::class, 'n', 'WITH', 'n.publication = p.id')
            ->groupBy('c.id')
            ->having('sum(n.value) >= 100')
            ->andWhere('c.expiredAt < :date')
            ->setParameter('date', new DateTime())
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return CodePromo[] Returns an array of CodePromo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CodePromo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
