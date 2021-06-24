<?php

namespace App\Repository;

use App\Entity\Uzytkownik;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method Uzytkownik|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uzytkownik|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uzytkownik[]    findAll()
 * @method Uzytkownik[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzytkownikRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * Password encoder.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry Manager registry
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct($registry, Uzytkownik::class);
    }
    /**
     * Query all records.
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('uzytkownik');
    }

    /**
     * @return Uzytkownik[]
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
        return $queryBuilder ?? $this->createQueryBuilder('uzytkownik');
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Uzytkownik $uzytkownik): void
    {
        $this->_em->remove($uzytkownik);
        $this->_em->flush();
    }

    // /**
    //  * @return Uzytkownik[] Returns an array of Uzytkownik objects
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
    public function findOneBySomeField($value): ?Uzytkownik
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Rejestruje użytkownika
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     */
    public function register(array $data)
    {
        $user = new Uzytkownik();
        $user->setNazwaUzytkownik($data['nazwa_uzytkownik']);
        $user->setHaslo(
            $this->passwordEncoder->encodePassword(
                $user,
                $data['haslo']
            )
        );
        $user->setRola([Uzytkownik::ROLE_USER]);
        $user->setUzytkownikDane($data['uzytkownikDane']);

        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param Uzytkownik  $user
     * @param string|null $newPasswordPlain
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Uzytkownik $user, string $newPasswordPlain = null)
    {
        if ($newPasswordPlain) {
            $user->setHaslo(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $newPasswordPlain
                )
            );
        }

        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param \App\Entity\Uzytkownik $uzytkownik
     * @param string|null $newPasswordPlain
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save_new(Uzytkownik $uzytkownik, string $newPasswordPlain = null)
    {
        if ($newPasswordPlain) {
            $uzytkownik->setHaslo(
                $this->passwordEncoder->encodePassword(
                    $uzytkownik,
                    $newPasswordPlain
                )
            );
        }

        $this->_em->persist($uzytkownik);
        $this->_em->flush();
    }
}
