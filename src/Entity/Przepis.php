<?php

namespace App\Entity;

use App\Repository\PrzepisRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=PrzepisRepository::class)
 * @ORM\Table(name="przepisy")
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
     */
    private $info;

    /**
     * Nazwa.
     * @var string
     * @ORM\Column(type="string", length=65)
     */
    private $nazwa;

    /**
     * Składniki.
     * @var string
     * @ORM\Column(type="text")
     */
    private $skladniki;

    /**
     * Kroki.
     * @var string
     * @ORM\Column(type="text")
     */
    private $kroki;

    /**
     * Kategoria.
     * @var Kategoria
     * @ORM\ManyToOne(targetEntity="Kategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id")
     * })
     */
    private $kategoria;

    /**
     * Data utworzenia.
     * @var \DateTimeInterface
     * @ORM\Column(type="date")
     */
    private $dataUtworzenia;

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

    /**
     * @return Kategoria
     */
    public function getKategoria(): Kategoria
    {
        return $this->kategoria;
    }

    /**
     * @param Kategoria $kategoria
     */
    public function setKategoria(Kategoria $kategoria): void
    {
        $this->kategoria = $kategoria;
    }
}
