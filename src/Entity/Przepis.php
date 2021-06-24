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
 *
 * @UniqueEntity(fields={"nazwa"})
 */
class Przepis
{
    /**
     * Primary key.
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Info.
     * @var string
     *
     * @ORM\Column(type="string", length=200)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="150",
     * )
     */
    private string $info;

    /**
     * Nazwa.
     * @var string
     *
     * @ORM\Column(type="string", length=65)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private string $nazwa;

    /**
     * Składniki.
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3", max="150",
     * )
     */
    private string $skladniki;

    /**
     * Kroki.
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="8",
     *)
     */
    private string $kroki;

    /**
     * Data utworzenia.
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="date")
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Assert\Type(type ="\DateTimeInterface")
     */
    private DateTimeInterface $dataUtworzenia;

    /**
     * @var Kategoria
     * Kategoria.
     * @ORM\ManyToOne(targetEntity=Kategoria::class, inversedBy="przepis")
     * @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id")
     */
    private Kategoria $kategoria;

    /**
     * Tagi.
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="przepis")
     * @ORM\JoinTable(name="przepisy_tagi")
     */
    private $tagi;

    /**
     * @ORM\ManyToOne(targetEntity=Uzytkownik::class, fetch="EXTRA_LAZY")
     */
    private ?Uzytkownik $author;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Komentarz", mappedBy="przepis", cascade={"remove"})
     */
    private $komentarze;

    /**
     * @var int
     *
     * @ORM\Column(name="thumb_up", type="integer")
     */
    private int $thumbUp = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="thumb_down", type="integer")
     */
    private int $thumbDown = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="thumb_diff", type="integer")
     */
    private int $thumbDiff = 0;

    /**
     * Przepis constructor.
     */
    public function __construct()
    {
        $this->tagi = new ArrayCollection();
        $this->komentarze = new ArrayCollection();
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
     *
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
     *
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
     *
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
     *
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
     * @param \DateTimeInterface $dataUtworzenia
     * @return \App\Entity\Przepis
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
     *
     * @return $this
     */
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

    /**
     * @param array $tagi
     */
    public function setTagi(array $tagi): void
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
     * @return Collection
     */
    public function getKomentarze(): Collection
    {
        return $this->komentarze;
    }

    /**
     * @param Collection $komentarze
     */
    public function setKomentarze(Collection $komentarze): void
    {
        $this->komentarze = $komentarze;
    }

    /**
     * @return int
     */
    public function getThumbUp(): int
    {
        return $this->thumbUp;
    }

    /**
     * @param int $thumbUp
     */
    public function setThumbUp(int $thumbUp): void
    {
        $this->thumbUp = $thumbUp;
        $this->thumbDiff = $this->thumbUp - $this->thumbDown;
    }

    /**
     * @return int
     */
    public function getThumbDown(): int
    {
        return $this->thumbDown;
    }

    /**
     * @param int $thumbDown
     */
    public function setThumbDown(int $thumbDown): void
    {
        $this->thumbDown = $thumbDown;
        $this->thumbDiff = $this->thumbUp - $this->thumbDown;
    }

    /**
     * @return int
     */
    public function getThumbDiff(): int
    {
        return $this->thumbDiff;
    }
}
