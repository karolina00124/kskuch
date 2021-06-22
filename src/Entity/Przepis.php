<?php

namespace App\Entity;

use App\Repository\PrzepisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * Kategoria.
     * @ORM\ManyToOne(targetEntity=Kategoria::class, inversedBy="przepis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kategoria;

    /**
     * Tagi.
     * @var array
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="przepis")
     * @ORM\JoinTable(name="przepisy_tagi")
     */
    private $tagi;

    /**
     * @ORM\ManyToOne(targetEntity=Uzytkownik::class, fetch="EXTRA_LAZY")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Komentarz::class,  fetch="EXTRA_LAZY")
     */
    private $komentarz;

    /**
     * Przepis constructor.
     */
    public function __construct()
    {
        $this->tagi = new ArrayCollection();
    }

    /**
     * Getter for Id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Info.
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * Setter for Info.
     * @param string $info
     * @return $this
     */
    public function setInfo(string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    /**
     * @param string $nazwa
     * @return $this
     */
    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSkladniki(): ?string
    {
        return $this->skladniki;
    }

    /**
     * @param string $skladniki
     * @return $this
     */
    public function setSkladniki(string $skladniki): self
    {
        $this->skladniki = $skladniki;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKroki(): ?string
    {
        return $this->kroki;
    }

    /**
     * @param string $kroki
     * @return $this
     */
    public function setKroki(string $kroki): self
    {
        $this->kroki = $kroki;
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
     * Setter for Data utworzenia.
     *
     * @param \DateTimeInterface $Datautworzenia Data utworzenia
     */
    public function setDataUtworzenia(DateTimeInterface $dataUtworzenia): self
    {
        $this->dataUtworzenia = $dataUtworzenia;
        return $this;
    }

    /**
     * @return Kategoria|null
     */
    public function getKategoria(): ?Kategoria
    {
        return $this->kategoria;
    }

    /**
     * @param Kategoria|null $kategoria
     * @return $this
     */
    public function setKategoria(?Kategoria $kategoria): self
    {
        $this->kategoria = $kategoria;

        return $this;
    }

    /**
     * @param Kategoria $kategoria
     * @return $this
     */
    public function addKategoria(Kategoria $kategoria): self
    {
        if (!$this->kategoria->contains($kategoria)) {
            $this->kategoria[] = $kategoria;
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTagi(): Collection
    {
        return $this->tagi;
    }

    /**
     * @param array $tagi
     */
    public function setTagi($tagi): void
    {
        $this->tagi = $tagi;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tagi->contains($tag)) {
            $this->tagi[] = $tag;
        }

    }

    /**
     * Remove tag from collection.
     * @param Tag $tag
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tagi->contains($tag)) {
            $this->tagi->removeElement($tag);
        }
    }

    /**
     * @return Uzytkownik|null
     */
    public function getAuthor(): ?Uzytkownik
    {
        return $this->author;
    }

    /**
     * @param UserInterface|null $author
     */
    public function setAuthor(?UserInterface $author): void
    {
        $this->author = $author;

    }

    /**
     * @return Komentarz|null
     */
    public function getKomentarz(): ?Komentarz
    {
        return $this->komentarz;
    }

    /**
     * @param Komentarz|null $komentarz
     */
    public function setKomentarz(?Komentarz $komentarz): void
    {
        $this->komentarz = $komentarz;

    }

}