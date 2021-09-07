<?php
/**
 * UzytkownikDaneRepository
 */

namespace App\Repository;

use App\Entity\UzytkownikDane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UzytkownikDane|null find($id, $lockMode = null, $lockVersion = null)
 * @method UzytkownikDane|null findOneBy(array $criteria, array $orderBy = null)
 * @method UzytkownikDane[]    findAll()
 * @method UzytkownikDane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzytkownikDaneRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UzytkownikDane::class);
    }

    /**
     * @return UzytkownikDane[]
     */
    public function getAll(): array
    {
        return $this->queryAll()->getQuery()->getResult();
    }

    /**
     * Save record.
     *
     * @param UzytkownikDane $uzytkownikDane UzytkownikDane entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(UzytkownikDane $uzytkownikDane): void
    {
        $this->_em->persist($uzytkownikDane);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param UzytkownikDane $uzytkownikDane UzytkownikDane entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(UzytkownikDane $uzytkownikDane): void
    {
        $this->_em->remove($uzytkownikDane);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('uzytkownikDane');
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
