<?php
/**
 * TagiDataTransformer transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagiDataTransformer.
 */
class TagiDataTransformer implements DataTransformerInterface
{
    /**
     * Tag repository.
     */
    private TagRepository $tagRepository;

    /**
     * TagiDataTransformer constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Transform array of tags to string of names.
     *
     * @param $tagi
     *
     * @return string Result
     */
    public function transform($tagi): string
    {
        if (null === $tagi) {
            return '';
        }

        $tagNames = [];

        foreach ($tagi as $tag) {
            $tagNames[] = $tag->getTagNazwa();
        }

        return implode(',', $tagNames);
    }

    /**
     * Transform string of tag names into array of Tag entities.
     *
     * @param string $value String of tag names
     *
     * @return array Result
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $tagTitles = explode(',', $value);

        $tagi = [];

        foreach ($tagTitles as $tagTitle) {
            if ('' !== trim($tagTitle)) {
                $tag = $this->tagRepository->findOneByTagNazwa(strtolower($tagTitle));
                if (null === $tag) {
                    $tag = new Tag();
                    $tag->setTagNazwa($tagTitle);
                    $this->tagRepository->save($tag);
                }
                $tagi[] = $tag;
            }
        }

        return $tagi;
    }
}
