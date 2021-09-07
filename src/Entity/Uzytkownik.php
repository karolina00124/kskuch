<?php
/**
 * Uzytkownik entity
 */

namespace App\Entity;

use App\Repository\UzytkownikRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UzytkownikRepository::class)
 */
class Uzytkownik implements UserInterface
{
    /**
     * Role user.
     *
     * @var string
     */
    public const ROLE_USER = 'ROLE_USER';

    /**
     * Role admin.
     *
     * @var string
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Primary key.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private ?string $nazwaUzytkownik;
    /**
     * The hashed password.
     *
     * @ORM\Column(type="string", length=191)
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private string $haslo;

    /**
     * @ORM\Column(type="json")
     */
    private array $rola = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UzytkownikDane", mappedBy="uzytkownik", cascade={"persist", "remove"})
     */
    private UzytkownikDane $uzytkownikDane;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNazwaUzytkownik(): ?string
    {
        return $this->nazwaUzytkownik;
    }

    /**
     * @param string $nazwaUzytkownik
     *
     * @return $this
     */
    public function setNazwaUzytkownik(string $nazwaUzytkownik): self
    {
        $this->nazwaUzytkownik = $nazwaUzytkownik;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHaslo(): ?string
    {
        return $this->haslo;
    }

    /**
     * @param string $haslo
     *
     * @return $this
     */
    public function setHaslo(string $haslo): self
    {
        $this->haslo = $haslo;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRola(): ?array
    {
        return $this->rola;
    }

    /**
     * @param array $rola
     *
     * @return $this
     */
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

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->getRola();
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->getHaslo();
    }

    /**
     * @return string|void
     */
    public function getUsername()
    {
        $this->getNazwaUzytkownik();
    }

    /**
     * @return UzytkownikDane
     */
    public function getUzytkownikDane(): UzytkownikDane
    {
        return $this->uzytkownikDane;
    }

    /**
     * @param UzytkownikDane $uzytkownikDane
     */
    public function setUzytkownikDane(UzytkownikDane $uzytkownikDane): void
    {
        $uzytkownikDane->setUzytkownik($this);
        $this->uzytkownikDane = $uzytkownikDane;
    }
}
