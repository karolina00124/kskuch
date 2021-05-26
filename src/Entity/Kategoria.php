<?php

namespace App\Entity;

use App\Repository\KategoriaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KategoriaRepository::class)
 * @ORM\Table(name="kategorie")
 */
class Kategoria
{
    /**
     * Id.
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nazwa.
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $kategoriaNazwa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKategoriaNazwa(): ?string
    {
        return $this->kategoriaNazwa;
    }

    public function setKategoriaNazwa(string $kategoriaNazwa): self
    {
        $this->kategoriaNazwa = $kategoriaNazwa;
        return $this;
    }
}
