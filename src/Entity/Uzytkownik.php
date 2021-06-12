<?php

namespace App\Entity;

use App\Repository\UzytkownikRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UzytkownikRepository::class)
 */
class Uzytkownik implements UserInterface
{
    /**
     * Role user.
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';

    /**
     * Role admin.
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $nazwa_uzytkownik;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $haslo;

    /**
     * @ORM\Column(type="json")
     */
    private $rola = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaUzytkownik(): ?string
    {
        return $this->nazwa_uzytkownik;
    }

    public function setNazwaUzytkownik(string $nazwa_uzytkownik): self
    {
        $this->nazwa_uzytkownik = $nazwa_uzytkownik;

        return $this;
    }

    public function getHaslo(): ?string
    {
        return $this->haslo;
    }

    public function setHaslo(string $haslo): self
    {
        $this->haslo = $haslo;

        return $this;
    }

    public function getRola(): ?array
    {
        return $this->rola;
    }

    public function setRola(array $rola): self
    {
        $this->rola = $rola;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRoles()
    {
        return $this->getRola();
    }

    public function getPassword()
    {
        return $this->getHaslo();
    }

    public function getUsername()
    {
        $this->getNazwaUzytkownik();
    }
}
