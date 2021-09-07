<?php
/**
 * Komentarz entity
 */

namespace App\Entity;

use App\Repository\KomentarzRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KomentarzRepository::class)
 * @ORM\Table(name="komentarze")
 */
class Komentarz
{
    /**
     * Id.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * Treść.
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="225",
     * )
     * @ORM\Column(type="string", length=255)
     */
    private ?string $tresc;

    /**
     * @ORM\ManyToOne(targetEntity=Uzytkownik::class, fetch="EXTRA_LAZY")
     */
    private ?Uzytkownik $autor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Przepis", inversedBy="komentarze")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="przepis_id", referencedColumnName="id")
     * })
     */
    private Przepis $przepis;

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
    public function getTresc(): ?string
    {
        return $this->tresc;
    }

    /**
     * @param string $tresc
     *
     * @return $this
     */
    public function setTresc(string $tresc): self
    {
        $this->tresc = $tresc;

        return $this;
    }

    /**
     * @return Uzytkownik|null
     */
    public function getAutor(): ?Uzytkownik
    {
        return $this->autor;
    }

    /**
     * @param Uzytkownik|null $autor
     *
     * @return $this
     */
    public function setAutor(?Uzytkownik $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @param Przepis $przepis
     */
    public function setPrzepis(Przepis $przepis): void
    {
        $this->przepis = $przepis;
    }

    /**
     * @return Przepis
     */
    public function getPrzepis(): Przepis
    {
        return $this->przepis;
    }
}
