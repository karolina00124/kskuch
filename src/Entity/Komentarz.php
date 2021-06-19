<?php

namespace App\Entity;

use App\Repository\KomentarzRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KomentarzRepository::class)
 * @ORM\Table(name="komentarze")
 */
class Komentarz
{
    /**
     * Id.
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tresc;

    /**
     * @ORM\ManyToOne(targetEntity=Uzytkownik::class,fetch="EXTRA_LAZY")
     */
    private $autor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTresc(): ?string
    {
        return $this->tresc;
    }

    public function setTresc(string $tresc): self
    {
        $this->tresc = $tresc;

        return $this;
    }

    public function getAutor(): ?Uzytkownik
    {
        return $this->autor;
    }

    public function setAutor(?Uzytkownik $autor): self
    {
        $this->autor = $autor;

        return $this;
    }
}
