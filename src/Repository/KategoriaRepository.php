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
    /**
     * Items per page.
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * KategoriaRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
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
            ->orderBy('k.id', 'ASC');
    }

    /**
     * @return Kategoria[]
     */
    public function getAll(): array
    {
        return $this->queryAll()->getQuery()->getResult();
    }
    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('kategoria');
    }
    /**
     * Save record.
     *
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Kategoria $kategoria): void
    {
        $this->_em->persist($kategoria);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Kategoria $kategoria): void
    {
        $this->_em->remove($kategoria);
        $this->_em->flush();
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
