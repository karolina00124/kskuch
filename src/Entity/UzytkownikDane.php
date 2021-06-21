<?php

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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Imię.
     * @ORM\Column(type="string", length=62, nullable=true)
     * @Assert\NotBlank
     */
    private $imie;

    /**
     * Nazwisko.
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $nazwisko;

    /**
     * Email.
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(?string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(?string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
