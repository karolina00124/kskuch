<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\User;
use App\Entity\Uzytkownik;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Password encoder.
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

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
        $user->setNazwaUzytkownik(sprintf('user'));
        $user->setRola([Uzytkownik::ROLE_USER]);
        $user->setHaslo(
            $this->passwordEncoder->encodePassword(
                $user,
                'user'
            )
        );
        $manager->persist($user);

        $userAdmin = new Uzytkownik();
        $userAdmin->setNazwaUzytkownik(sprintf('admin'));
        $userAdmin->setRola([Uzytkownik::ROLE_USER, Uzytkownik::ROLE_ADMIN]);
        $userAdmin->setHaslo(
            $this->passwordEncoder->encodePassword(
                $userAdmin,
                'admin'
            )
        );
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
