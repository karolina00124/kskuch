<?php

namespace App\Repository;

use App\Entity\Uzytkownik;
use App\Entity\UzytkownikDane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * Password encoder.
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct($registry, Uzytkownik::class);
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
     * @param Uzytkownik $user
     * @param string|null $newPasswordPlain
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Uzytkownik $user, string $newPasswordPlain = null)
    {
        if($newPasswordPlain) {
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
}
