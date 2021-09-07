<?php
/**
 * Kategoria entity.
 */

namespace App\Entity;

use App\Repository\KategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Kategoria.
 *
 * @ORM\Entity(repositoryClass=KategoriaRepository::class)
 * @ORM\Table(name="kategorie")
 *
 * @UniqueEntity(fields={"kategoriaNazwa"})
 */
class Kategoria
{
    /**
     * Id.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Nazwa.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private string $kategoriaNazwa;

    /**
     * @ORM\OneToMany(targetEntity=Przepis::class, mappedBy="kategoria", fetch ="EXTRA_LAZY")
     */
    private Collection $przepis;

    /**
     * Kategoria constructor.
     */
    public function __construct()
    {
        $this->przepis = new ArrayCollection();
    }

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
    public function getKategoriaNazwa(): ?string
    {
        return $this->kategoriaNazwa;
    }

    /**
     * @param string $kategoriaNazwa
     *
     * @return $this
     */
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

    /**
     * @param Przepis $przepis
     *
     * @return $this
     */
    public function addPrzepis(Przepis $przepis): self
    {
        if (!$this->przepis->contains($przepis)) {
            $this->przepis[] = $przepis;
            $przepis->setKategoria($this);
        }

        return $this;
    }

    /**
     * @param Przepis $przepis
     *
     * @return $this
     */
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
