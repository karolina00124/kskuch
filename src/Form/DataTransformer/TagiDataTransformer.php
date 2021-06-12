<?php
namespace App\Form\DataTransformer;

use App\Repository\TagRepository;
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
       $tagNames =[];
       foreach ($tagi as $tag)
       {
          $tagNames[] = $tag->getTagNazwa();
       }
       return implode(',',$tagNames);
    }

    public function reverseTransform($value)
    {
       //$tagTitles =explode()
    }

}