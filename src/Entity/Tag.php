<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
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
}
