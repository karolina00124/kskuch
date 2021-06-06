<?php

namespace App\Entity;

use App\Repository\KategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Przepis::class, mappedBy="kategoria")
     */
    private $przepis;

    public function __construct()
    {
        $this->przepis = new ArrayCollection();
    }

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

    /**
     * @return Collection|Przepis[]
     */
    public function getPrzepis(): Collection
    {
        return $this->przepis;
    }

    public function addPrzepis(Przepis $przepis): self
    {
        if (!$this->przepis->contains($przepis)) {
            $this->przepis[] = $przepis;
            $przepis->setKategoria($this);
        }

        return $this;
    }

    public function removePrzepis(Przepis $przepis): self
    {
        if ($this->przepis->removeElement($przepis)) {
            // set the owning side to null (unless already changed)
            if ($przepis->getKategoria() === $this) {
                $przepis->setKategoria(null);
            }
        }

        return $this;
    }


}
