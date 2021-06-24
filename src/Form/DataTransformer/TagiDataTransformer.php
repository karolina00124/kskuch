<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use App\Repository\TagRepository;
use App\Entity\Tag;

/**
 * Class TagiDataTransformer.
 */
class TagiDataTransformer implements DataTransformerInterface
{
    /**
     * Tag repository.
     *
     * @var \App\Repository\TagRepository
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $tagTitles = explode(',', $value);

        $tagi = [];

        foreach ($tagTitles as $tagTitle) {
            if ('' !== trim($tagTitle)) {
                $tag = $this->tagRepository->findOneByTagNazwa(strtolower($tagTitle));
                if (null == $tag) {
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
