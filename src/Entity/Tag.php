<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tagi")
 *
 * @UniqueEntity(fields={"tagNazwa"})
 */
class Tag
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
    private string $tagNazwa;

    /**
     * Data utworzenia.
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $dataUtworzenia;

    /**
     * Przepis.
     *
     * @ORM\ManyToMany(targetEntity=Przepis::class, mappedBy="tagi")
     */
    private Collection $przepis;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->przepis = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTagNazwa(): ?string
    {
        return $this->tagNazwa;
    }

    /**
     * @param string $tagNazwa
     *
     * @return $this
     */
    public function setTagNazwa(string $tagNazwa): self
    {
        $this->tagNazwa = $tagNazwa;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDataUtworzenia(): ?DateTimeInterface
    {
        return $this->dataUtworzenia;
    }

    /**
     * @param DateTimeInterface $dataUtworzenia
     *
     * @return $this
     */
    public function setDataUtworzenia(DateTimeInterface $dataUtworzenia): self
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

    /**
     * @param Przepis $przepis
     *
     * @return $this
     */
    public function addPrzepis(Przepis $przepis): self
    {
        if (!$this->przepis->contains($przepis)) {
            $this->przepis[] = $przepis;
            $przepis->addTag($this);
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
            $przepis->removeTag($this);
        }

        return $this;
    }
}
