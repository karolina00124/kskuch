<?php
/**
 * UzytkownikDane entity.
 */

namespace App\Entity;

use App\Repository\UzytkownikDaneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UzytkownikDaneRepository::class)
 */
class UzytkownikDane
{
    /**
     * Id.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * Imię.
     *
     * @ORM\Column(type="string", length=62, nullable=true)
     *
     * @Assert\NotBlank
     */
    private ?string $imie;

    /**
     * Nazwisko.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank
     */
    private ?string $nazwisko;

    /**
     * Email.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank
     * @Assert\Email
     */
    private ?string $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Uzytkownik", inversedBy="uzytkownikDane")
     * @ORM\JoinColumn(name="uzytkownik_id", referencedColumnName="id")
     */
    private Uzytkownik $uzytkownik;

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
    public function getImie(): ?string
    {
        return $this->imie;
    }

    /**
     * @param string|null $imie
     *
     * @return $this
     */
    public function setImie(?string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    /**
     * @param string|null $nazwisko
     *
     * @return $this
     */
    public function setNazwisko(?string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Uzytkownik
     */
    public function getUzytkownik(): Uzytkownik
    {
        return $this->uzytkownik;
    }

    /**
     * @param Uzytkownik $uzytkownik
     */
    public function setUzytkownik(Uzytkownik $uzytkownik): void
    {
        $this->uzytkownik = $uzytkownik;
    }
}
