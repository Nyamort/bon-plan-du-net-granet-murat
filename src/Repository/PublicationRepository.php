<?php

namespace App\Repository;

use App\Entity\Commentaire;
use App\Entity\Notation;
use App\Entity\Publication;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publication>
 *
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    public function save(Publication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Publication[] Returns an array of Publication objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Publication
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findALaUne()
    {
        $lastWeek = new DateTime('-1 week');
        return $this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin(Commentaire::class, 'c', 'WITH', 'c.publication = p.id')
            ->andWhere('p.publishedAt > :lastWeek')
            ->setParameter('lastWeek', $lastWeek)
            ->groupBy('p.id')
            ->orderBy('count(c.id)', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findHot()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(Notation::class, 'n', 'WITH', 'n.publication = p.id')
            ->groupBy('p.id')
            ->having('sum(n.value) >= 100')
            ->getQuery()
            ->getResult()
        ;
    }

    public function search(string $search): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere('p.title LIKE :search')
            ->orWhere('p.description LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSemaine(): array
    {
        $lastWeek = new DateTime('-1 week');
        return $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere('p.publishedAt > :lastWeek')
            ->setParameter('lastWeek', $lastWeek)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->andWhere('p.author = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function averageNotationByUser($user){
        $date = new DateTime('-1 year');
        return $this->createQueryBuilder('p')
            ->select('avg(n.value)')
            ->innerJoin(Notation::class, 'n', 'WITH', 'n.publication = p.id')
            ->andWhere('p.author = :user AND p.publishedAt < :date')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findHotByUser($user){
        return $this->createQueryBuilder('p')
            ->innerJoin(Notation::class, 'n', 'WITH', 'n.publication = p.id')
            ->andWhere('p.author = :user')
            ->setParameter('user', $user)
            ->groupBy('p.id')
            ->having('sum(n.value) >= 100')
            ->select('count(p)')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


}
