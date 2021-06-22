<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tagi")
 * @UniqueEntity(fields={"title"})
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
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $tagNazwa;

    /**
     * Data utworzenia.
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataUtworzenia;

    /**
     * Przepis.
     * @ORM\ManyToMany(targetEntity=Przepis::class, mappedBy="tagi")
     */
    private $przepis;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->przepis = new ArrayCollection();
    }

    /**
     * Getter for Id.
     * @return int|null
     */
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
        $this->tagNazwa = $tagNazwa;

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

    public function addPrzepis(Przepis $przepis): self
    {
        if (!$this->przepis->contains($przepis)) {
            $this->przepis[] = $przepis;
            $przepis->addTag($this);
        }

        return $this;
    }

    public function removePrzepis(Przepis $przepis): self
    {
        if ($this->przepis->removeElement($przepis)) {
            $przepis->removeTag($this);
        }

        return $this;
    }
}
