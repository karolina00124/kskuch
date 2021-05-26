<?php

namespace App\Repository;

use App\Entity\Kategoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kategoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kategoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kategoria[]    findAll()
 * @method Kategoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kategoria::class);
    }

    /**
     * Query all records.
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('k')
            ->orderBy('k.kategoriaNazwa', 'ASC');
    }

    /**
     * @return Kategoria[]
     */
    public function getAll(): array
    {
        return $this->queryAll()->getQuery()->getResult();
    }

    // /**
    //  * @return Kategoria[] Returns an array of Kategoria objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kategoria
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
