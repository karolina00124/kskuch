<?php

namespace App\Entity;

use App\Repository\KategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Kategoria.
 * @ORM\Entity(repositoryClass=KategoriaRepository::class)
 * @ORM\Table(name="kategorie")
 * @UniqueEntity(fields={"kategoriaNazwa"})
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
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $kategoriaNazwa;

    /**
     * @ORM\OneToMany(targetEntity=Przepis::class, mappedBy="kategoria", fetch ="EXTRA_LAZY")
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
