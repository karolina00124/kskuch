<?php

namespace App\Repository;

use App\Entity\Komentarz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Komentarz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Komentarz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Komentarz[]    findAll()
 * @method Komentarz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KomentarzRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 15;
    /**
     * KomentarzRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Komentarz::class);
    }

    /**
     * Query all records.
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->getOrcreateQueryBuilder()
            ->select(  'partial komentarz.{id, tresc}',
                'partial autor.{id,nazwa_uzytkownik}')
            ->join('komentarz.autor', 'autor')
            ->orderBy('komentarz.id', 'ASC');
    }

    /**
     * @return Komentarz[]
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
        return $queryBuilder ?? $this->createQueryBuilder('komentarz');
    }
    /**
     * Save record.
     *
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Komentarz $komentarz): void
    {
        $this->_em->persist($komentarz);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Komentarz $komentarz): void
    {
        $this->_em->remove($komentarz);
        $this->_em->flush();
    }

    // /**
    //  * @return Komentarz[] Returns an array of Komentarz objects
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
    public function findOneBySomeField($value): ?Komentarz
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
