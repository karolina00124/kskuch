<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tagi")
 */
class Tag
{
    /**
     * Id.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nazwa.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $tagNazwa;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataUtworzenia;

    /**
     * @ORM\ManyToMany(targetEntity=Przepis::class, mappedBy="tags")
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

    public function getTagNazwa(): ?string
    {
        return $this->tagNazwa;
    }

    public function setTagNazwa(string $tagNazwa): self
    {
        $this->tag_nazwa = $tagNazwa;

        return $this;
    }

    public function getDataUtworzenia(): ?\DateTimeInterface
    {
        return $this->dataUtworzenia;
    }

    public function setDataUtworzenia(\DateTimeInterface $dataUtworzenia): self
    {
        $this->dataUtworzenia = $dataUtworzenia;

        return $this;
    }

    /**
     * @return Collection|Przepis[]
     */
    public function getPrzepis(): Collection
    {
        return $this->przepis;
    }

    public function addPrzepi(Przepis $przepi): self
    {
        if (!$this->przepis->contains($przepi)) {
            $this->przepis[] = $przepi;
            $przepi->addTag($this);
        }

        return $this;
    }

    public function removePrzepi(Przepis $przepi): self
    {
        if ($this->przepis->removeElement($przepi)) {
            $przepi->removeTag($this);
        }

        return $this;
    }
}
