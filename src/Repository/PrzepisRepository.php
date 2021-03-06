<?php
/**
 * PrzepisRepository
 */

namespace App\Repository;

use App\Entity\Przepis;
use App\Entity\Uzytkownik;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * PrzepisRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Przepis::class);
    }

    /**
     * @param Uzytkownik $uzytkownik
     *
     * @return QueryBuilder
     */
    public function queryByAuthor(Uzytkownik $uzytkownik): QueryBuilder
    {
        $queryBuilder = $this->queryAll();
        $queryBuilder->andWhere('przepis.author = :author')
            ->setParameter('author', $uzytkownik);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array $filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder()
            ->select(
                'partial przepis.{id, dataUtworzenia, nazwa, thumbDiff}',
                'partial tagi.{id,tagNazwa}',
            )
            ->leftJoin('przepis.tagi', 'tagi')
            ->orderBy('przepis.dataUtworzenia', 'DESC');

        if (array_key_exists('kategoria_id', $filters) && $filters['kategoria_id'] > 0) {
            $qb->where('przepis.kategoria = :kategoria_id')
                ->setParameter('kategoria_id', $filters['kategoria_id'])
            ;
        }

        if (array_key_exists('tag_id', $filters) && $filters['tag_id'] > 0) {
            $qb->andWhere('tagi IN (:tag_id)')
                ->setParameter('tag_id', $filters['tag_id'])
            ;
        }

        if (array_key_exists('autor_id', $filters) && $filters['autor_id'] > 0) {
            $qb->andWhere('przepis.author = :autor_id')
                ->setParameter('autor_id', $filters['autor_id'])
            ;
        }

        return $qb;
    }

    /**
     * Save record.
     *
     * @param Przepis $przepis Przepis entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Przepis $przepis): void
    {
        $this->_em->persist($przepis);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param Przepis $przepis Przepis entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Przepis $przepis): void
    {
        $this->_em->remove($przepis);
        $this->_em->flush();
    }

    /**
     * @param Uzytkownik $uzytkownik
     */
    public function deleteForUzytkownik(Uzytkownik $uzytkownik)
    {
        $this->createQueryBuilder('p')
            ->delete()
            ->where('p.author = :user_id')
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
        return $queryBuilder ?? $this->createQueryBuilder('przepis');
    }
}
