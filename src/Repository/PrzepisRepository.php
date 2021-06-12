<?php

namespace App\Repository;

use App\Entity\Przepis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Przepis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Przepis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Przepis[]    findAll()
 * @method Przepis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrzepisRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * PrzepisRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Przepis::class);
    }

    /**
     * Query all records.
     * @param array $filters
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder()
            ->select(
                'partial przepis.{id, dataUtworzenia, nazwa}',
                'partial tagi.{id,tagNazwa}'
            )
            ->leftJoin('przepis.tagi', 'tagi')
            ->orderBy('przepis.dataUtworzenia', 'DESC');

        if(array_key_exists('kategoria_id', $filters) && $filters['kategoria_id'] > 0) {
            $qb->where('przepis.kategoria = :kategoria_id')
                ->setParameter('kategoria_id', $filters['kategoria_id'])
            ;
        }

        if(array_key_exists('tag_id', $filters) && $filters['tag_id'] > 0) {
            $qb->andWhere('tagi IN (:tag_id)')
                ->setParameter('tag_id', $filters['tag_id'])
            ;
        }

        return $qb;
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
        return $queryBuilder ?? $this->createQueryBuilder('przepis');
    }
    /**
     * Save record.
     *
     * @param \App\Entity\Przepis $przepis Przepis entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Przepis $przepis): void
    {
        $this->_em->persist($przepis);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Przepis $przepis Przepis entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Przepis $przepis): void
    {
        $this->_em->remove($przepis);
        $this->_em->flush();
    }

    // /**
    //  * @return Przepis[] Returns an array of Przepis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Przepis
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
