<?php

namespace App\Repository;

use App\Entity\UzytkownikDane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UzytkownikDane|null find($id, $lockMode = null, $lockVersion = null)
 * @method UzytkownikDane|null findOneBy(array $criteria, array $orderBy = null)
 * @method UzytkownikDane[]    findAll()
 * @method UzytkownikDane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzytkownikDaneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UzytkownikDane::class);
    }

    // /**
    //  * @return UzytkownikDane[] Returns an array of UzytkownikDane objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UzytkownikDane
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
