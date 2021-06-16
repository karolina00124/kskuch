<?php
namespace App\Form\DataTransformer;

use App\Repository\TagRepository;
use App\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagiDataTransformer implements DataTransformerInterface
{
    private  TagRepository $tagRepository;

    /**
     * TagiDataTransformer constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

     public function transform($tagi)
      {
       if (null === $tagi)
       {
          return '';
     }
    $tagNames = [];
       foreach ($tagi as $tag)
      {
        $tagNames[] = $tag->getTagNazwa();
     }
    return implode(',',$tagNames);
    }

    public function reverseTransform($value)
    {
        $tagTitles = explode(',', $value);
        $tagi = [];
        foreach ($tagTitles as $tagTitle){
            if('' === trim($tagTitle)){
                continue;
            }

            $tagTitle = strtolower($tagTitle);

            $tag = $this->tagRepository->findOneByTagNazwa($tagTitle);
            if (null === $tag)
            {
              $tag = new Tag();
              $tag->setTagNazwa($tagTitle);
              $this->tagRepository->save($tag);
            }
            $tagi[] = $tag;
        }
        return $tagi;
    }

}