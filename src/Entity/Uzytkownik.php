<?php

namespace App\Entity;

use App\Repository\UzytkownikRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UzytkownikRepository::class)
 */
class Uzytkownik
{
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
}
