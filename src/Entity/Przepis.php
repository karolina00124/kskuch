<?php

namespace App\Entity;

use App\Repository\PrzepisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Przepis.
 * @ORM\Entity(repositoryClass=PrzepisRepository::class)
 * @ORM\Table(name="przepisy")
 * @UniqueEntity(fields={"nazwa"})
 */
class Przepis
{
    /**
     * Primary key.
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Info.
     * @var string
     * @ORM\Column(type="string", length=200)
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="150",
     * )
     */
    private $info;

    /**
     * Nazwa.
     * @var string
     * @ORM\Column(type="string", length=65)
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $nazwa;

    /**
     * Składniki.
     * @var string
     * @ORM\Column(type="text")
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3", max="150",
     * )
     */
    private $skladniki;

    /**
     * Kroki.
     * @var string
     * @ORM\Column(type="text")
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="8",
     *)
     */
    private $kroki;

    /**
     * Data utworzenia.
     * @var \DateTimeInterface
     * @ORM\Column(type="date")
     * @Gedmo\Timestampable(on="create")
     * @Assert\Type(type ="\DateTimeInterface")
     */
    private $dataUtworzenia;

    /**
     * @ORM\ManyToOne(targetEntity=Kategoria::class, inversedBy="przepis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kategoria;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="przepis")
     * @ORM\JoinTable(name="przepisy_tagi")
     */
    private $tagi;

    public function __construct()
    {
        $this->tagi = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;
        return $this;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;
        return $this;
    }

    public function getSkladniki(): ?string
    {
        return $this->skladniki;
    }

    public function setSkladniki(string $skladniki): self
    {
        $this->skladniki = $skladniki;
        return $this;
    }

    public function getKroki(): ?string
    {
        return $this->kroki;
    }

    public function setKroki(string $kroki): self
    {
        $this->kroki = $kroki;
        return $this;
    }

    public function getDataUtworzenia(): ?DateTimeInterface
    {
        return $this->dataUtworzenia;
    }

    public function setDataUtworzenia(DateTimeInterface $dataUtworzenia): self
    {
        $this->dataUtworzenia = $dataUtworzenia;
        return $this;
    }

    public function getKategoria(): ?Kategoria
    {
        return $this->kategoria;
    }

    public function setKategoria(?Kategoria $kategoria): self
    {
        $this->kategoria = $kategoria;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTagi(): Collection
    {
        return $this->tagi;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tagi->contains($tag)) {
            $this->tagi[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tagi->removeElement($tag);

        return $this;
    }

}