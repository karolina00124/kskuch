<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Uzytkownik;
use App\Entity\UzytkownikDane;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    public const ADMIN_REFERENCE = 'admin';
    public const USER_REFERENCE = 'user';

    /**
     * Password encoder.
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $user = new Uzytkownik();
        $user->setNazwaUzytkownik('user');
        $user->setRola([Uzytkownik::ROLE_USER]);
        $user->setHaslo(
            $this->passwordEncoder->encodePassword(
                $user,
                'user'
            )
        );
        $manager->persist($user);

        $userAdmin = new Uzytkownik();
        $userAdmin->setNazwaUzytkownik('admin');
        $userAdmin->setRola([Uzytkownik::ROLE_USER, Uzytkownik::ROLE_ADMIN]);
        $userAdmin->setHaslo(
            $this->passwordEncoder->encodePassword(
                $userAdmin,
                'admin'
            )
        );
        $manager->persist($userAdmin);

        $manager->flush();

        $userDane = new UzytkownikDane();
        $userDane->setUzytkownik($user);
        $userDane->setImie('User');
        $userDane->setNazwisko('Nowak');
        $userDane->setEmail('user@nowak.com');
        $manager->persist($userDane);
        $manager->flush();

        $userAdminDane = new UzytkownikDane();
        $userAdminDane->setUzytkownik($userAdmin);
        $userAdminDane->setImie('Admin');
        $userAdminDane->setNazwisko('Kowalski');
        $userAdminDane->setEmail('admin@kowalski.com');
        $manager->persist($userAdminDane);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
        $this->addReference(self::ADMIN_REFERENCE, $userAdmin);
    }
}
