<?php
/**
 * KomentarzRepository
 */

namespace App\Repository;

use App\Entity\Komentarz;
use App\Entity\Uzytkownik;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
    public const PAGINATOR_ITEMS_PER_PAGE = 15;

    /**
     * KomentarzRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Komentarz::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->getOrcreateQueryBuilder()
            ->select(
                'partial komentarz.{id, tresc}',
                'partial autor.{id,nazwa_uzytkownik}'
            )
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
     * Save record.
     *
     * @param Komentarz $komentarz Komentarz entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Komentarz $komentarz): void
    {
        $this->_em->persist($komentarz);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param Komentarz $komentarz Komentarz entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Komentarz $komentarz): void
    {
        $this->_em->remove($komentarz);
        $this->_em->flush();
    }

    /**
     * @param Uzytkownik $uzytkownik
     */
    public function deleteForUzytkownik(Uzytkownik $uzytkownik)
    {
        $this->createQueryBuilder('k')
            ->delete()
            ->where('k.autor = :user_id')
            ->setParameter('user_id', $uzytkownik->getId())
            ->getQuery()
            ->execute()
        ;
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
        return $queryBuilder ?? $this->createQueryBuilder('komentarz');
    }
}
